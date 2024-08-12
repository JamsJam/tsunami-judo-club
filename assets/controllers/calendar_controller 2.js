import { Controller } from '@hotwired/stimulus';
import { getComponent } from '@symfony/ux-live-component';
import dayjs from 'dayjs';
import fr from 'dayjs/locale/fr';
import localizedFormat from 'dayjs/plugin/localizedFormat';
import localeData from 'dayjs/plugin/localeData';

/* stimulusFetch: 'lazy' */

export default class extends Controller {
    static targets = ['years', 'month', 'daysContainer'];

    static values = {
        today: String,
        year: String,
        month: String,
        daysInMonth: Number,
        componentInitialize: { type: Boolean, default: false }
    };

    //? ============== Initialize

    async initialize() {
        // Extend Day.js with localeData and set the locale to French
        dayjs.locale(fr);
        dayjs.extend(localeData, localizedFormat);
        this.getRightFormat(this.todayValue, 'DD-MM-YYYY');

        try {
            //? ========== Initialize component
            this.component = await getComponent(this.element);
            this.confirmInitialize();

            //? ========== Component Event Trigger
            this.component.on('model:set', (model, value) => {
                if (model == 'value') this.handelTodayChange(value);
                if (model == 'days') {
                    // Handle 'days' model change
                }
            });

        } catch (error) {
            console.error('Failed to initialize component:', error);
        }
    }

    //? ============== Target Connect

    yearsTargetConnected() {
        // Display the year from the 'today' value
        this.yearValue = String(dayjs(this.todayValue).year());
        this.yearsTarget.innerHTML = `<p>${this.yearValue}</p>`;
    }

    monthTargetConnected() {
        // Display the month from the 'today' value in French
        this.monthValue = dayjs.months()[dayjs(this.todayValue).month()];
        this.monthTarget.innerHTML = `<p>${this.monthValue}</p>`;
    }

    daysContainerTargetConnected() {
        this.setDayInMonth();
    }

    //? ============== Component Event Listener

    handleReload() {
        this.setDayInMonth();
        this.component.render();
    }

    //? ============== Utility Methods

    /**
     * Format the given date to the specified format
     * @param {String} date - The date to format
     * @param {String} format - The format to use (default: DD-MM-YYYY)
     */
    getRightFormat(date, format = 'DD-MM-YYYY') {
        this.todayValue = dayjs(date).format(format);
    }

    confirmInitialize() {
        this.confirmInitializeValue = true;
        const daysToDisplay = this.getDayBefore(this.todayValue)
            .concat(this.getDayCurrent(this.todayValue, this.daysInMonthValue))
            .concat(this.getDayNext(this.todayValue, this.daysInMonthValue));
        this.setDisplayDay(daysToDisplay, this.component);
    }

    handelTodayChange(value) {
        this.todayValue = value;
        this.getRightFormat(value);
        this.setDayInMonth();
        this.yearFromToday();
        this.monthFromToday();
    }

    connect() {
        this.setDayInMonth();
    }

    //? ============== Date Calculation Methods

    /**
     * Get the days before the current month
     * @param {dayjs} today - The current date
     * @returns {Array} - Array of days before the current month
     */
    getDayBefore(today) {
        const firstDayIndex = dayjs(today).date(1).day();
        const daysBefore = [];
        if (firstDayIndex !== 0) {
            const daysBeforeNumber = firstDayIndex - 1;
            for (let index = 0; index < daysBeforeNumber; index++) {
                const element = dayjs(today).date(parseInt(`-${index}`));
                daysBefore.push({
                    date: element.format('DD-MM-YYYY'),
                    id: element.format('DDMMYYYY')
                });
            }
        }
        return daysBefore.sort((a, b) => new Date(a.date.split('-').reverse().join('-')) - new Date(b.date.split('-').reverse().join('-')));
    }

    /**
     * Get the days after the current month
     * @param {dayjs} today - The current date
     * @param {int} dayInMonth - Number of days in the current month
     * @returns {Array} - Array of days after the current month
     */
    getDayNext(today, dayInMonth) {
        const lastDayIndex = dayjs(today).date(dayInMonth).day();
        const daysNext = [];
        if (lastDayIndex !== 0) {
            const daysNextNumber = 7 - lastDayIndex;
            for (let index = 1; index <= daysNextNumber; index++) {
                const element = dayjs(today).date(index + dayInMonth);
                daysNext.push({
                    date: element.format('DD-MM-YYYY'),
                    id: element.format('DDMMYYYY')
                });
            }
        }
        return daysNext.sort();
    }

    /**
     * Get the days of the current month
     * @param {dayjs} today - The current date
     * @param {int} dayInMonth - Number of days in the current month
     * @returns {Array} - Array of days in the current month
     */
    getDayCurrent(today, dayInMonth) {
        const daysCurrent = [];
        for (let index = 1; index <= dayInMonth; index++) {
            const element = dayjs(today).date(parseInt(index));
            daysCurrent.push({
                date: element.format('DD-MM-YYYY'),
                id: element.format('DDMMYYYY'),
            });
        }
        return daysCurrent;
    }

    /**
     * Display the calculated days in the component
     * @param {Array} monthDays - The days to display
     * @param {Object} component - The component to update
     */
    setDisplayDay(monthDays, component) {
        component.set('days', monthDays);
        console.log(monthDays.at(0),monthDays.at(-1))
        component.set('beginCalendar', monthDays.at(0).date);
        component.set('endCalendar', monthDays.at(-1).date);
        component.action('getEvents')
        // component.emit('eventArray');
        component.render();
        
    }

    /**
     * Calculate and update the number of days in the current month
     */
    setDayInMonth() {
        this.daysInMonthValue = dayjs(this.todayValue).daysInMonth();
    }

    yearFromToday() {
        this.yearValue = String(dayjs(this.todayValue).year());
        this.yearsTarget.innerHTML = `<p>${this.yearValue}</p>`;
    }

    monthFromToday() {
        this.monthValue = dayjs.months()[dayjs(this.todayValue).month()];
        this.monthTarget.innerHTML = `<p>${this.monthValue}</p>`;
    }
}
