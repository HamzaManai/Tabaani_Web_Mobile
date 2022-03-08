window.onload = () => {
    let links = document.querySelectorAll("[data-delete]")
    console.log(links);

    for (link of links) {
        link.addEventListener("click", function (e) {
            e.preventDefault()

            if (confirm("Voulez-vous supprimer cette image ?")) {

                fetch(this.getAttribute("href"), {
                    method: "DELETE",
                    headers: {
                        "X-Requested-With": "XMLHttpRequest",
                        "Content-Type": "application/json"
                    },
                    body: JSON.stringify({
                        "_token": this.dataset.token
                            + console.log(this.dataset.token)
                    })
                }).then(
                    response => response.json()
                ).then(data => {
                    if (data.success) {
                        this.parentElement.remove();
                        console.log("success");
                    }
                    else {
                        alert(data.error)
                        console.log("error");
                    }
                }).catch(e => alert(e) + console.log("error2"))
            }
        })
    }
}