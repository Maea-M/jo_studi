/**
 * @property {HtmlElement} form
 * @property {HtmlElement} sorting
 */

console.log('hello filter')
export default class Filter {

    /**
     * 
     * @param {HTMLElement|null} element 
     */
    constructor (element){
        if (element==null){
            return
        }
        console.log('je suis en cours de construction')
        this.form = element.querySelector('js-filter-form')
        this.sorting = element.querySelector('js-filter-sorting')


        this.bindEvents()

    }
    /**
     * Ajouter les comportements aux diéffrents éléments
     */
    bindEvents(){
        this.sorting.querySelectorAll('a').forEach(a => {
            a.addEventListenner('click', e=>{
                e.preventDefault()
                this.loadUrl(a.getAttribute('href'))
            })
        });
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