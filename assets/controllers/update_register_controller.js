import { Controller } from '@hotwired/stimulus';

/*
* The following line makes this controller "lazy": it won't be downloaded until needed
* See https://github.com/symfony/stimulus-bridge#lazy-controllers
*/
/* stimulusFetch: 'lazy' */
export default class extends Controller {
    static targets = ['radios', 'radioContainer', 'form', 'pratique']
    // ...


    //* commentaire 
    //? commentaire 
    //! commentaire 
    //todo commentaire 
    //// commentaire 


    async changeOptions(e){

        if(e.target.value == 1){

            const requestBody = e.target.getAttribute('name') + '=' + e.target.value + '&' +document.querySelector('#register_step4__token').getAttribute('name')+'='+document.querySelector('#register_step4__token').value ;
            
            
            const updateFormResponse = await this.updateForm(requestBody, this.formTarget.getAttribute('action'), this.formTarget.getAttribute('method'));
            const html =  this.parseTextToHtml(updateFormResponse);

            const commissaire = html.querySelector('#register_step4_commissairelvl')
            const arbitre = html.querySelector('#register_step4_arbitreLvl')
            const licence = html.querySelector('#licence')
            const grade = html.querySelector('#register_step4_grade')


            
            this.pratiqueTarget.after(licence)
            

            
            let newArbitre = document.createElement('div')
            newArbitre.setAttribute('id','arbitrelvl')
            newArbitre.innerHTML  = "<label for='register_step4_arbitreLvl'>Quel est votre niveau d'arbitrage ?</label><div class='custom-select'>" + arbitre.outerHTML + "</div>";
            
            let newCommissaire = document.createElement('div')
            newCommissaire.setAttribute('id','commissairelvl')
            newCommissaire.innerHTML  = "<label for='register_step4_commissairelvl'>Quel est votre niveau de commissaire sportif ?</label><div class='custom-select'>" + commissaire.outerHTML + "</div>";
            
            let newGrade = document.createElement('div')
            newGrade.setAttribute('id','grade')
            newGrade.innerHTML  = "<label for='register_step4_grade'>Quel est votre grade actuel ?</label><div class='custom-select'>" +grade.outerHTML + "</div>";

            

            
            licence.after(newCommissaire)
            licence.after(newArbitre)
            licence.after(newGrade)
        }
        else{
            document.querySelector('#commissairelvl').remove()
            document.querySelector('#arbitrelvl').remove()
            document.querySelector('#licence').remove()
            document.querySelector('#grade').remove()

            // commissaire.remove()
            // arbitre.remove()
            // licence.remove()
            // grade.remove()
        }


    };



    async updateForm(data, url, method){
        const response = await fetch(url, {
            method: method,
            body: data,
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
                'charset': 'utf-8',
                'accept': 'text/html'
            }
        })
        const text = await response.text(); 
        return text;
    }

  

    parseTextToHtml(text){
        const parser = new DOMParser();
        const html = parser.parseFromString(text, 'text/html');
  
        return html;
    };
}
