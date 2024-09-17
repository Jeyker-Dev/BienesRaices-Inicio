// Obtener referencia al campo de número
var campoNumero_1 = document.getElementById("Precio");
var botonClick = document.getElementById('btnClick');

botonClick.addEventListener("click", function()
{
    document.getElementById("confirmForm").submit();
});

// Validar la entrada del usuario
campoNumero_1.addEventListener("input", function() {
  // Eliminar caracteres no numéricos del valor del campo
    this.value = this.value.replace(/[^0-9]/g, '');
});

// Validar la entrada del usuario
campoNumero_2.addEventListener("input", function() {
    // Eliminar caracteres no numéricos del valor del campo
    this.value = this.value.replace(/[^0-9]/g, '');
});



document.addEventListener('DOMContentLoaded', function llamar()
{
    darkMode();
    eventListeners();

}); // Here end Event

function darkMode()
{
    const botonDarkMode = document.querySelector('.dark-mode-boton');

     botonDarkMode.addEventListener('click', function()
     {
        document.body.classList.toggle('dark-mode');
     }); // Here end Event

}   // Here End Function

function eventListeners()
{
    const mobileMenu = document.querySelector('.mobile-menu');
    mobileMenu.addEventListener('click', navegacionResponsive); // Here end Event
}   // Here end Function

function navegacionResponsive()
{
    const navegacion = document.querySelector('.navegacion');

    if(navegacion.classList.contains('mostrar'))
    {
        navegacion.classList.remove('mostrar');
    }   // Here End If
    else
    {
        navegacion.classList.add('mostrar');
    }   // Here end Else

}   // Here end Function



function confirmarEliminar()
{
    Swal.fire(
        {
            title: 'Eliminar',
            text: '¿Estas Seguro que Quieres Eliminar Estos Datos?',
            width: '50%',
            padding: '1rem',
            showCancelButton: true,
            confirmButtonText: 'Si',
            cancelButtonText: "No"
        }).then((result) => 
        {
            if(result.isConfirmed)
            {
                console.log('Hola');
                return;
            }
        });
}



