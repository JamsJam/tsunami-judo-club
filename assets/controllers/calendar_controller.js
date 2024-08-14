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



        this.initialiseDayjs()
        this.getRightFormat(this.todayValue, 'DD-MM-YYYY')

        try {


            //? ========== initialize component
                this.component = await getComponent(this.element);
                console.log('Component successfully initialized:', this.component);


            //? ========== component Event triger
                this.setComponentListener(this.component)
                
        } catch (error) {
            console.error('Failed to initialize component:', error);
        }
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





    handelTodayChange(value) {
        this.todayValue = value
        this.getRightFormat(value )
        this.setDayInMonth()
        this.yearFromToday()
        this.monthFromToday()
    }







    /**
     * @description Set TwigComponents Eventlistener
     * @param {*} TwigComponent
     * @returns {void}
     */
    setComponentListener(TwigComponent)
    {

        TwigComponent.on('connect', (component) => {

        });

        TwigComponent.on('disconnect ', (component) => {

        });


        //* events are only dispatched when the component is re-rendered (via an action or a model change).
        TwigComponent.on('render:started', (html, backendResponse, shouldRender= { shouldRender: true}) => {

        });


        //* events are only dispatched when the component is re-rendered (via an action or a model change).
        TwigComponent.on('render:finished', (component) => {
            
            this.handleReload()
        });


        TwigComponent.on('loading.state:started', (html, backendRequest) => {

        });


        TwigComponent.on('loading.state:finished', (html) => {
        

        });


        TwigComponent.on('model:set', (model, value, component) => {


            switch (model) {
                
                case 'today':

                    this.handelTodayChange(value)
                    break;
            
                default:
                    break;
            }

        });
    }





    handleReload(){
        this.setDayInMonth()
        this.component.render()
    }


    setDayInMonth() {

        this.daysInMonthValue = dayjs(this.todayValue).daysInMonth();
        
    }


    yearFromToday(){
        this.yearValue = String(dayjs(this.todayValue).year());
        this.yearsTarget.innerHTML = `<p>${this.yearValue}</p>`;
    }

    monthFromToday(){
        this.monthValue = dayjs.months()[dayjs(this.todayValue).month()];
        this.monthTarget.innerHTML = `<p>${this.monthValue}</p>`;
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






    //? helper daysjs


        initialiseDayjs(){
            dayjs.extend(localeData, localizedFormat );
            dayjs.locale(fr);
        }

        /**
         * 
         * @param {string} date date d'aujourd'hui
         * @param {string} format format de sortie default: 'DD-MM-YYYY'
         * @returns {string} date au format donnée
         */
        getRightFormat(date,format){

            this.todayValue = dayjs(date).format(format = 'DD-MM-YYYY')
        }

}
