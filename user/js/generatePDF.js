function generatePDF() {
    // Choose the element that our invoice is rendered in.
    var element = document.getElementById("content");
    // Choose the element and save the PDF for our user.
    html2pdf(element, {
            margin: 1,
            filename: 'myfile.pdf',
            image: {
                type: 'jpeg',
                quality: 1
            },
            html2canvas: {
                scale: 2,
                logging: true
            },
            jsPDF: {
                // unit: 'in',
                format: 'a4',
                // orientation: 'l'
            }
        })
        .from(element)
        // .save();
}