import { Controller } from '@hotwired/stimulus';

/*
* The following line makes this controller "lazy": it won't be downloaded until needed
* See https://github.com/symfony/stimulus-bridge#lazy-controllers
*/
/* stimulusFetch: 'lazy' */
export default class extends Controller {

    static targets = [ 
            'main',
            'modalContainer',
            'modal'
        ]
    static values = {
        isEventModal: {type: Boolean, default: false},
        mainEvent : {type: String, default: null},
        beginAt: {type: String, default: null}
    } ;

    

    
    initialize(){
        // console.group('ready')
    }

    //* ============== Eventlistener handler
   
    handleModalEvent(e){
        const {openModal, trigger, beginAt} = e.detail.content

        this.mainEventValue = trigger
        this.isEventModalValue = openModal
        this.beginAtValue = beginAt

    }

    //* ============================




    //* ============== value change listener

    isEventModalValueChanged(current, old){

        switch (true) {
            case !old && current:
                this.displayModalContainer()

                break;
            case old && !current:
                this.destroyModal()
                break;
        
            default:

                console.error('unautorized modal action')
                break;
        }

    }

    //* ============================ 

    
    displayModalContainer(){

        this.createElement()
    }
    
    openModal(){
         
    }



    createElement(){
        let container = document.createElement('div')
        container.classList.add('modalContainer')
        console.log(container)
        this.mainTarget.appendChild(container)

    }
}
