function senhaHabilitar()
{
    const chksenha = document.getElementById('usuario_editar_senha_checkbox');
    const senha = document.getElementById('usuario_editar_senha');
    const confirmarSenha = document.getElementById('usuario_editar_confirmarSenha');

    if (chksenha.checked)
    {
        senha.disabled          = false;
        confirmarSenha.disabled = false;
    }
    else
    {
        senha.disabled          = true;
        senha.value = '';

        confirmarSenha.disabled = true;
        confirmarSenha.value = '';
    }
}

function preview_image(event)
{
    var reader = new FileReader();
    reader.onload =
        function()
        {
            var output = document.getElementById('ExibirIMG_inputfile');
            output.src = reader.result;
        }
    reader.readAsDataURL(event.target.files[0]);
}

function confirmar(titulo, pergunta, form)
{
    swal({
        title: titulo,
        text: pergunta,
        icon: "warning",
        buttons: true,
        dangerMode: true,
        })
        .then((willDelete) => {
        if (willDelete) {
            enviarForm(form);
        }
        else
        {
            swal(
                {
                    title:  "Processo cancelado!",
                    text:   'Registro NÂO foi afetado!',
                    button: "OK",
                }
            )
        }
        });
}

function enviarForm(form)
{
    form.submit();
}
