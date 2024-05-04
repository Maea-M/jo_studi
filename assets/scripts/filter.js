export default class Filter {
    constructor () {
        console.log('essai1')
        /* 1er temps = il sert à définir les variables, les propriétés */
        this.form = document.querySelector('.js-filter-form')
        this.content = document.querySelector('.js-filter-form')
        this.sorting = document.querySelector('.js-filter-sorting')
        /* 2nd temps = lancer les fonctions, les méthodes */
        this.init()
    }

    /*Méthode pour lancer toutes les focntions de ma classe*/
    init(){
        this.bindEvents()
    }

    /*Méthode pour sélectionner le clci qur le a*/
    bindEvents(){
        this.sorting.addEventListener('click', e=>{
            if (e.target.tagName === 'A'){
                console.log('clicl clqici')
                e.preventDefault()
                this.loadUrl(a.getAttribute('href'))
            }
        })  
    }
    
    async loadUrl(url){
        const response = await fetch(url, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
    
        if (response.status >=200 && response.status <300){
            const data = await response.json()
            this.content.innerHTML = data.content
        } else{
            console.error(response)
        }
    }
}

