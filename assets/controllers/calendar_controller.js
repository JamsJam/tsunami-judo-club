import { Controller } from '@hotwired/stimulus';
import { getComponent } from '@symfony/ux-live-component';
import dayjs from 'dayjs';
import fr from 'dayjs/locale/fr';
import localizedFormat from 'dayjs/plugin/localizedFormat'
import localeData from 'dayjs/plugin/localeData';

/* stimulusFetch: 'lazy' */

export default class extends Controller {
    static targets = ['years', 'month', 'daysContainer'];

    static values = {
        today: String,
        year: String,
        month: String,
        daysInMonth: Number
    };

    
    async initialize() {


        // Extend Day.js with localeData and set the locale to French
        dayjs.locale(fr);
        dayjs.extend(localeData, localizedFormat );
        this.getRightFormat(this.todayValue, 'DD-MM-YYYY')

        try {


            //? ========== initialize component
            this.component = await getComponent(this.element);
            console.log('Component successfully initialized:', this.component);

            //? ========== component Event triger
            this.component.on('model:set', (model, value, component) => {
                
                model =='today' && this.handelTodayChange(value)

            });


        } catch (error) {
            console.error('Failed to initialize component:', error);
        }
    }


    /**
     * 
     * @param {String} date date d'aujourd'hui
     * @param {string} format format de sortie default: DD-MM-YYYY 
     */
    getRightFormat(date,format){

        this.todayValue = dayjs(date).format(format = 'DD-MM-YYYY')
    }

    handelTodayChange(value) {
        this.todayValue = value
        this.getRightFormat(value )
        this.setDayInMonth()
        this.yearFromToday()
        this.monthFromToday()
    }


    yearsTargetConnected() {
        // Display the year from the 'today' value
        this.yearValue = String(dayjs(this.todayValue).year());
        this.yearsTarget.innerHTML = `<p>${this.yearValue}</p>`;
        console.log('Year connected:', this.yearValue);
    }

    monthTargetConnected() {
        // Display the month from the 'today' value in French
        this.monthValue = dayjs.months()[dayjs(this.todayValue).month()];
        this.monthTarget.innerHTML = `<p>${this.monthValue}</p>`;
        console.log('Month connected:', this.monthValue);
    }

    daysContainerTargetContainer(){

        this.setDayInMonth()
        // this.component.set('today','04-02-2000')
    }


     connect() {
        // Calculate and update the number of days in the month
        
        this.setDayInMonth();
        console.log('CONNECT',this.getDayBefore(this.todayValue))
        console.log('CONNECT',this.getDayCurrent(this.todayValue, this.daysInMonthValue))

    }

    /**
     * 
     * @param {dayjs} today 
     * @returns {Array} days to display before the current days'month
     */
    getDayBefore(today){
        const firstDayIndex = dayjs(today).date(1).day()
        console.log(firstDayIndex)
        const daysBefore = []
        if(firstDayIndex !== 0){

            const daysBeforeNumber = firstDayIndex - 1 
            

            for (let index = 0; index < daysBeforeNumber ; index++) {
                const element = dayjs(today).date(parseInt(`-${index}`));
                
                daysBefore.push({
                    date: element.format('DD-MM-YYYY'),
                    id: element.format('DDMMYYYY')
                })
            }
        }

        return daysBefore.sort((a, b) => {
            // Convertir les dates au format JJ-MM-AAAA en objets Date
            let dateA = new Date(a.date.split('-').reverse().join('-'));
            let dateB = new Date(b.date.split('-').reverse().join('-'));
            
            return dateA - dateB; // Tri ascendant
        });
    }

    /**
     * 
     * @param {dayjs} today 
     * @param {int} dayInMonth days in the rcurrent month
     * @returns {Array} days to display next the current days'month
     */
    getDayNext(today,dayInMonth){
        const lastDayIndex = dayjs(today,).date(dayInMonth).day()
 
        const daysNext = []

        if ( lastDayIndex !== 0) {

            const daysNextNumber =  7 - lastDayIndex 
            

            for (let index = 1; index < daysNextNumber ; index++) {
                const element = dayjs(today).date(index + dayInMonth);
                
                daysNext.push({
                    date: element.format('DD-MM-YYYY'),
                    id: element.format('DDMMYYYY')
                })
            }
        }

        return daysNext.sort()
    }
    /**
     * 
     * @param {dayjs} today today
     * @param {int} dayInMonth days in the rcurrent month
     * @returns {Array} days the current days'month
     * 
     */
    getDayCurrent(today, dayInMonth){

        // const firstDayIndex = dayjs(today).date(1).day()
 
        const daysCurrent = []
        
            for (let index = 1; index <= dayInMonth ; index++) {
                const element = dayjs(today).date(parseInt(index));
                
                daysCurrent.push({
                    date: element.format('DD-MM-YYYY'),
                    id: element.format('DDMMYYYY'),
                })
            }
        return daysCurrent
    }



    setDayInMonth() {

        this.daysInMonthValue = dayjs(this.todayValue).daysInMonth();
        
    }


    handleReload(){
        
        this.setDayInMonth()
        // this.component.set('today','04-02-2000')
        // this.component.on('model:set'),(model, value, component) => {
        //     console.log(model, value, component) 
        // }
        // this.component.set('dayInMonth',this.daysInMonthValue)
        // this.daysInMonthValue = dayjs(this.todayValue).daysInMonth()
        // this.yearFromToday()
        // this.monthFromToday()
        this.component.render()
        console.log(this.todayValue)

    }

    yearFromToday(){
        this.yearValue = String(dayjs(this.todayValue).year());
        this.yearsTarget.innerHTML = `<p>${this.yearValue}</p>`;
        console.log('Year connected:', this.yearValue);
    }

    monthFromToday(){
        this.monthValue = dayjs.months()[dayjs(this.todayValue).month()];
        this.monthTarget.innerHTML = `<p>${this.monthValue}</p>`;
        console.log('Month connected:', this.monthValue);
    }
}
