"use strict"

const modalDelete = document.getElementById("modal-delete");

function openDeleteModal(id){
    modalDelete.showModal();

    //Pequeño delay para permitir el render 
    requestAnimationFrame(() => modalDelete.classList.add("show"));

    document.getElementById("idDelete").value = id;
}

modalDelete.addEventListener("click", e => {
    // e.preventDefault(); 

    if(e.target.closest(".cerrar-modal") || !e.target.closest(".modal-body")){
        modalDelete.classList.remove("show"); 
        modalDelete.classList.add("closing");

        setTimeout(() =>{
            modalDelete.close(); 
            modalDelete.classList.remove("closing");
        },300)
    }
})

