import { Controller } from '@hotwired/stimulus';
import { getComponent } from '@symfony/ux-live-component';
import dayjs from 'dayjs';
import fr from 'dayjs/locale/fr';
import localizedFormat from 'dayjs/plugin/localizedFormat'
import localeData from 'dayjs/plugin/localeData';

/* stimulusFetch: 'lazy' */

export default class extends Controller {
    static targets = [
        'calendar',
        'years', 
        'month', 
        'daysContainer',
    ];

    static values = {
        today: String,
        year: String,
        month: String,
        daysInMonth: Number,
        calendarDays: Array,
        component: Object,
        isComponentInitialize: {type:Boolean, default:false}
    };



    pendingActions = [];

    async initialize() {
        
        this.initialiseDayjs()

        try {


            //? ========== initialize component
                this.component = await getComponent(this.element);

                this.isComponentInitializeValue = true


                //? ========== component Event triger
                this.setComponentListener(this.component)
                this.executePendingActions()
                
        } catch (error) {
            console.error('Failed to initialize component:', error);
        }
    }



    calendarTargetConnected() {
        // Display the year from the 'today' value
        const today  = (JSON.parse(this.calendarTarget.getAttribute('data-live-props-value'))).today
        console.log(today)
        this.todayValue = today
        
    }



    connect() {
    }







    //* ============== twig component listener

        /**
         *  Set TwigComponents Eventlistener
         * @param {*} TwigComponent
         * @returns {void}
         */
        setComponentListener(TwigComponent)
        {

            TwigComponent.on('connect', (component) => {
                console.log("EVENT : Composant connecté")

            });
            
            TwigComponent.on('disconnect ', (component) => {
                console.log("EVENT : Composant déconnecté")
                
            });
            
            
            //* events are only dispatched when the component is re-rendered (via an action or a model change).
            TwigComponent.on('render:started', (html, backendResponse, shouldRender= { shouldRender: true}) => {
                console.log("EVENT : composant refresh start")
                
            });
            
            
            //* events are only dispatched when the component is re-rendered (via an action or a model change).
            TwigComponent.on('render:finished', (component) => {
                console.log("EVENT : composant refresh end")
                
                // this.handleReload()
            });
            
            
            TwigComponent.on('loading.state:started', (html, backendRequest) => {
                
                console.log("EVENT : composant loading start")
            });
            
            
            TwigComponent.on('loading.state:finished', (html) => {
                
                console.log("EVENT : composant loading end ")
                console.log("EVENT : composant loading end ")
                
            });
            
            
            TwigComponent.on('model:set', (model, value, component) => {
                
                console.log("EVENT SET : model " , model )
                console.log("EVENT SET : value " , value)


                switch (model) {
                    
                    case 'today':

                        // this.handelTodayChange(value)
                        break;
                
                    default:
                        break;
                }

            });
        }

    //* ============== 





    //* ============== Value change listener

        todayValueChanged(current, old){

                this.daysInMonthValue = dayjs(this.todayValue).daysInMonth()
                this.yearValue = dayjs(this.todayValue).year()
                this.monthValue = dayjs.months()[dayjs(this.todayValue).month()]
                this.calendarDaysValue = this.getCalendarDays(dayjs(this.todayValue), this.daysInMonthValue)

        }

        monthValueChanged(current, old){
            if( typeof(current) == 'string' && current.length){

                this.monthTarget.innerHTML = `<p>${current}</p>`;
            }
        }

        yearValueChanged(current, old){
            // console.log('YEAR',current,old)
            if( !isNaN(current)){

                this.yearsTarget.innerHTML = `<p>${current}</p>`;
            }
        }


        calendarDaysValueChanged(current, old){
            // console.log(current)
            if(current.length){
                this.addPendingAction(()=>this.component.set('days',current))
                // this.addPendingAction(()=>this.component.set('beginCalendar',current.at(0).date))
                // this.addPendingAction(()=>this.component.set('endCalendar',current.at(-1).date))
                // this.addPendingAction(()=>this.component.action('fetchEvent'))
                this.addPendingAction(()=>this.component.render())
            }
            
        }


        isComponentInitializeValueChanged(current, old){
            console.log('Component successfully initialized:' + current );
        }

    //* ============== 




    //* ============== pending Action from component
    
        executePendingActions(component) {
            while (this.pendingActions.length > 0) {
                const action = this.pendingActions.shift();
                action();
            }
        }

        addPendingAction(action) {
            if (this.isComponentInitializeValue) {
                action();
            } else {
                this.pendingActions.push(action);
            }
        }
    //* ============== 
    
    
    
    
    
    
    //* ============== getCalendar days methodes

        /**
     * 
     * @param {dayjs} today today
     * @param {int} dayInMonth days in the rcurrent month
     * @returns {Array} days the current days'month
     * 
     */
        getCurrentMonthDays(today, dayInMonth){

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
        getPreviousMonthDays(today){
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
        getNextMonthDays (today,dayInMonth){
            const lastDayIndex = dayjs(today).date(dayInMonth).day()

            const daysNext = []
    
            if ( lastDayIndex !== 0) {
    
                const daysNextNumber =  7 - lastDayIndex 
                
    
                for (let index = 1; index <= daysNextNumber ; index++) {
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
         * @param {*} today 
         * @param {*} dayInMonth 
         * @returns 
         */
        getCalendarDays(today,dayInMonth){


            const calendarDays = this.getPreviousMonthDays(today).concat(this.getCurrentMonthDays(today, dayInMonth)).concat(this.getNextMonthDays (today,dayInMonth))

            return calendarDays
        }

    //* ============== 




    //* ============== Helper daysjs


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

            // this.todayValue = dayjs(date).format(format = 'DD-MM-YYYY')
        }

    //* ==============
}
