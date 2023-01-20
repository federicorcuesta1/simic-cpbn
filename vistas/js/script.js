/*document.addEventListener("DOMContentLoaded", () => {
    // Escuchamos el click del botón
    const $boton = document.querySelector("#btnCrearPdf");
    $boton.addEventListener("click", () => {
        const $elementoParaConvertir = document.body; // <-- Aquí puedes elegir cualquier elemento del DOM
        html2pdf()
            .set({
                margin: 1,
                filename: 'documento.pdf',
                image: {
                    type: 'jpeg',
                    quality: 0.98
                },
                html2canvas: {
                    scale: 3, // A mayor escala, mejores gráficos, pero más peso
                    letterRendering: true,
                },
                jsPDF: {
                    unit: "in",
                    format: "a3",
                    orientation: 'portrait' // landscape o portrait
                }
            })
            .from($elementoParaConvertir)
            .save()
            .catch(err => console.log(err));
    });
});

$('#print').click(function() {

    var w = document.getElementById("contenedor").offsetWidth;
    var h = document.getElementById("contenedor").offsetHeight;
    html2canvas(document.getElementById("contenedor"), {
        dpi: 300, // Set to 300 DPI
        scale: 3, // Adjusts your resolution
        onrendered: function(canvas) {
            var img = canvas.toDataURL("image/png", 1);
            var doc = new jsPDF('L', 'px', [w, h]);
            doc.addImage(img, 'PNG', 0, 0, w, h);
            doc.save('certificado.pdf');
        }
    });
});

$(function() {
    $('#download').click(function() {
        var options = {};
        var pdf = new jsPDF('p', 'pt', 'a4');
        pdf.addHTML($("#contenedor"), 15, 15, options, function() {
            pdf.save('certificado.pdf');
        });
    });
});*/