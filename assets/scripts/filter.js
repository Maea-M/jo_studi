window.onload = () => {
    const FiltersForm = document.querySelector('#filters')

    // on boucle sur les inputs
    document.querySelectorAll('#filters input').forEach(input =>{
        input.addEventListener('change', ()=>{
            const Form = new FormData(FiltersForm)

            //On fabrique l'url
            const Params = new URLSearchParams()
            Form.forEach((value, key) => {
                Params.append(value, key)
            })

            // on récupère l'url active
            const Url =  new URL(window.location.href)
            console.log(Url)

            //on lance la requête ajax
            fetch(Url.pathname+ '?' + Params.toString() + '&ajax=1',{
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            } ).then(
                response => response.json()
            ).then(data =>{
                const content = document.querySelector("#content")
                content.innerHTML = data.content
            })
            .catch(e => alert(e))
        })
    })
}