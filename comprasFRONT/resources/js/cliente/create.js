class Create {
    constructor(){
        $('#tipoCliente').on('change', (e) => {
            let tipoCliente = $(e.target).find('option:selected').html()

            console.log($(e.target).val() == '')
            if($(e.target).val() == ''){
                $('#identificacaoCliente').attr('hidden', true)
            } else {
                $('#identificacaoCliente').find('#labelTipo').html(tipoCliente)
                $('#identificacaoCliente').removeAttr('hidden')
            }
            

        })

    }
}

let create = new Create()