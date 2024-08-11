import { Controller } from '@hotwired/stimulus';

/*
* The following line makes this controller "lazy": it won't be downloaded until needed
* See https://github.com/symfony/stimulus-bridge#lazy-controllers
*/
/* stimulusFetch: 'lazy' */
export default class extends Controller {

    static targets = [  "burger", 'navMobile' ]
    static values = {
        active: {type: Boolean, default: false} ,
    }

    initialize(){

    }
    
    connect(){
    }
    
    onBurgerTargetConnect(){
        activateBurger()

    }

    toogleState(){
        this.activeValue = !this.activeValue 
    }
    
    activateBurger(){

        this.toogleState()

        if(this.activeValue){

            
            this.burgerTarget.classList.add('active') 
            document.querySelector("#navMobile").classList.add('active')
        } else{
            
            
            this.burgerTarget.classList.remove('active')
            document.querySelector("#navMobile").classList.remove('active')
        }

    }



}
