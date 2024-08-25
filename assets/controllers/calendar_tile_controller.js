import { Controller } from '@hotwired/stimulus';
import { getComponent } from '@symfony/ux-live-component';
import dayjs from 'dayjs';
import fr from 'dayjs/locale/fr';
import localizedFormat from 'dayjs/plugin/localizedFormat'
import localeData from 'dayjs/plugin/localeData';

/*
* The following line makes this controller "lazy": it won't be downloaded until needed
* See https://github.com/symfony/stimulus-bridge#lazy-controllers
*/
/* stimulusFetch: 'lazy' */
export default class extends Controller {
    static targets = [
        'tile',
        'dayNumber',
        'ponctuelEvent',
        'longEvent',
        'allDayEvent'
    ]
    static values = {
        day:String,
        dayid: String,
        tileNumber : Number,
    }
    
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






    //* ============== TargetConnect listener
        tileTargetConnected(){
        }

        dayNumberTargetConnected(){
            this.displayDayNumber(this.dayNumberTarget, this.dayValue )
            
        }
        
        //* ============================ 
        
        connect(){}



    //* ============== Value changeListener


    //* ============================ 




    //* ============== twig component listener
        /**
         *  Set TwigComponents Eventlistener
         * @param {*} TwigComponent
         * @returns {void}
         */
        setComponentListener(TwigComponent)
        {

            TwigComponent.on('connect', (component) => {
                // console.log("EVENT : Composant connecté")

            });
            
            TwigComponent.on('disconnect ', (component) => {
                // console.log("EVENT : Composant déconnecté")
                
            });
            
            
            //* events are only dispatched when the component is re-rendered (via an action or a model change).
            TwigComponent.on('render:started', (html, backendResponse, shouldRender= { shouldRender: true}) => {
                // console.log("EVENT : composant refresh start")
                
            });
            
            
            //* events are only dispatched when the component is re-rendered (via an action or a model change).
            TwigComponent.on('render:finished', (component) => {
                // console.log("EVENT : composant refresh end")
                // console.log('day', this.dayValue);
                // console.log('uniqID', this.dayidValue)
                
                // this.handleReload()
            });
            
            
            TwigComponent.on('loading.state:started', (html, backendRequest) => {
                
                // console.log("EVENT : composant loading start")
            });
            
            
            TwigComponent.on('loading.state:finished', (html) => {
                
                // console.log("EVENT : composant loading end ")

                
            });
            
            
            TwigComponent.on('model:set', (model, value, component) => {
                
                // console.log("EVENT SET -> model :" , model )
                // console.log("EVENT SET -> value :" , value)


                switch (model) {
                    
                    case 'today':

                        // this.handelTodayChange(value)
                        break;
                
                    default:
                        break;
                }

            });
        }


    //* ============================




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

    //* ============================




    //* ============== pending Action from component
        executePendingActions(component) {
            while (this.pendingActions.length > 0) {
                const action = this.pendingActions.shift();
                action();
            }
        }

        /**
         * 
         * @param {Function} action 
         */
        addPendingAction(action) {
            if (this.isComponentInitializeValue) {
                action();
            } else {
                this.pendingActions.push(action);
            }
        }
    //* ============================ 




    //* ============== HTML manipulation
        displayDayNumber(target, today ){
            
            //  this.getDayNumberOfMonth(today)
             target.textContent =  "" + this.getDayNumberOfMonth(today)
        }

    //* ============================ 
    



    //* ============== Event Dispatch
        
    addEventTrigger(){
        this.dispatch('openModal', { detail: { content: {
            openModal: true,
            trigger: 'add',
            beginAt: this.getDayjsFormat(this.dayValue)
        }}})

    }
    
    //* ============================ 




    //* ============== dayjs helper
        /**
         * return Date's day numbers of the month
         * @param {string} date date au format DD-MM-YYYY
         * @returns {number}
         */
        getDayNumberOfMonth(date ){
            let formatedDate = this.getDayjsFormat(date)
            return dayjs(formatedDate).date()
        }


        /**
         * get te format for Dayjs
         * @param {string} date date au format DD-MM-YYYY
         */
        getDayjsFormat(date){

            const [day, month,year] = date.split('-')
            let formatedDate = [year,month,day].join('-')
            return formatedDate
        }
    //* ============================ 





    //* ============== Event Helper



    //* ============================ 
    

}
