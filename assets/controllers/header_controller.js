import { Controller } from '@hotwired/stimulus';

/*
* The following line makes this controller "lazy": it won't be downloaded until needed
* See https://github.com/symfony/stimulus-bridge#lazy-controllers
*/
/* stimulusFetch: 'lazy' */
export default class extends Controller {
    
    static targets = [ "navDesktop", "navMobile", "burger", "header" ]
    static values = {

        responsiveMode : String
    } ;

    initialize(){

        this.responsiveModeValue =  this.setResponsiveState();
    }

    connect() {


        this.adapteResponsiveNav(this.responsiveModeValue);
        
    }




    getWindowSize()  {
        return window.innerWidth
     }
 
 
    setResponsiveState(){
        
        let mode ;

        if(this.getWindowSize() < 769 ){

            mode = "Mobile"
        }else{
            
            mode = "Desktop"
            
        }
        return mode
        
    }
     
     
    adapteResponsiveNav(mode) {
        
        switch (mode) {
            case "Mobile":
                this.navDesktopTarget.classList.add('hidden')
                this.burgerTarget.classList.remove('hidden')
                document.querySelector("#navMobile").classList.remove('hidden')
                break;
                
            case "Desktop":

                this.navDesktopTarget.classList.remove('hidden')
                
                this.burgerTarget.classList.add('hidden')
                this.burgerTarget.classList.remove('active')

                document.querySelector("#navMobile").classList.add('hidden')
                document.querySelector("#navMobile").classList.remove('active')

                
                break;
        
            default:
                break;
        }
    }

    valueVerifyer(){
    return this.responsiveModeValue ===  this.setResponsiveState() 
    }



    



    onResize() {
        if( this.valueVerifyer() ){
            return
        }else{

            this.responsiveModeValue =  this.setResponsiveState();
            
            this.adapteResponsiveNav(this.responsiveModeValue);
        }
    }
}


        
