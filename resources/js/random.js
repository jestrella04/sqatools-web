function generateBatchUploadExportObject(args) {
    var merchantId = args.merchantId;
    var invoiceCount = parseInt(args.invoiceCount);
    var email = args.email;
    var lineItemMin = parseInt(args.lineItemMin);
    var lineItemMax = parseInt(args.lineItemMax);
    var amountMax = args.amountMax;
    var currentDate = new Date();
    var formatDate = ('0' + (currentDate.getMonth() + 1)).slice(-2) + currentDate.getDate().toString() + currentDate.getFullYear().toString(); 

    var exportObject = {};

    for (var i = 0; i < invoiceCount; i++) {
        exportObject[i] = {}
        exportObject[i].header = {}
        exportObject[i].header.type = 'H';
        exportObject[i].header.customerNumber = 'CU-' + chance.string({ length: 7, pool: '0123456789' });
        exportObject[i].header.customerName = chance.name();
        exportObject[i].header.customerAddressLine1 = chance.address()
        exportObject[i].header.customerAddressLine2 = '';
        exportObject[i].header.customerCity = chance.city();
        exportObject[i].header.customerState = chance.state();
        exportObject[i].header.customerZip = chance.zip();
        exportObject[i].header.invoiceCreditTerms = '';
        exportObject[i].header.creditManagerName = '';
        exportObject[i].header.accountsReceivableBalance = '';
        exportObject[i].header.reserved1 = '';
        exportObject[i].header.shipToCustomer = '';
        exportObject[i].header.shipToName = '';
        exportObject[i].header.shipToAddressLine1 = '';
        exportObject[i].header.shipToAddressLine2 = '';
        exportObject[i].header.shipToCity = '';
        exportObject[i].header.shipToState = '';
        exportObject[i].header.shipToZip = '';
        exportObject[i].header.reserved2 = '';
        exportObject[i].header.reserved3 = '';
        exportObject[i].header.purchaseOrderNumber = '';
        exportObject[i].header.reserved4 = '';
        exportObject[i].header.emailAddress = placeholderReplace(email);
        exportObject[i].header.merchantId = merchantId;

        exportObject[i].lineItems = {};

        var lineItemCount = chance.integer({ min: lineItemMin, max: lineItemMax });
        var lineItemInvoice = 'BU-' + chance.string({ length: 10, pool: '0123456789' });

        for (var l = 0; l < lineItemCount; l++) {
            var lineItemAmount = chance.dollar({ max: amountMax }).replace('$', '');
            var description = chance.age() + ' ' + chance.capitalize(chance.word()) + ' ' + chance.animal();

            exportObject[i].lineItems[l] = {};
            exportObject[i].lineItems[l].type = 'D';
            exportObject[i].lineItems[l].invoiceNumber = lineItemInvoice;
            exportObject[i].lineItems[l].salesOrderNumber = '';
            exportObject[i].lineItems[l].lineItemNumber = parseInt(l) + 1;
            exportObject[i].lineItems[l].typeOfDocument = 'IN';
            exportObject[i].lineItems[l].typeOfAmount = '+';
            exportObject[i].lineItems[l].shippingDate = '';
            exportObject[i].lineItems[l].purchaseOrderNumber = '';
            exportObject[i].lineItems[l].partNumber = '';
            exportObject[i].lineItems[l].partDescription = description;
            exportObject[i].lineItems[l].orderQuantity = '1.00';
            exportObject[i].lineItems[l].shipmentQuantity = '1.00';
            exportObject[i].lineItems[l].backOrderedQuantity = 0;
            exportObject[i].lineItems[l].individualUnitPrice = lineItemAmount;
            exportObject[i].lineItems[l].discountPercentage = 0;
            exportObject[i].lineItems[l].extendedPrice = lineItemAmount;
            exportObject[i].lineItems[l].taxAmount = 0;
            exportObject[i].lineItems[l].orderDate = '';
            exportObject[i].lineItems[l].invoiceDueDate = formatDate;
            exportObject[i].lineItems[l].invoiceGeneratedDate = formatDate;
            exportObject[i].lineItems[l].invoicePdfFilename = '';
        }        
    }

    return exportObject;    
}

function ebppBatchUploadObjectToCsv(args) {
    var object = Object.values(args.object) || null;
    var columnDelimiter = args.columnDelimiter || ',';
    var lineDelimiter = args.lineDelimiter || '\n';
    var includeHeader = args.includeHeader || true;
    var fileContents = '';

    // Generate header lines
    if (includeHeader) {
        var headerKeys = Object.keys(object[0].header);
        var lineItemKeys = Object.keys(object[0].lineItems[0]);

        // Append header column titles (EBPP BU ignores the first H line)
        fileContents += combineArrayToString({
            object: headerKeys,
            columnDelimiter: columnDelimiter,
            lineDelimiter: lineDelimiter
        }).replace('type' + columnDelimiter, 'H' + columnDelimiter);

        // Append line items column titles (EBPP BU ignores the first D line)
        fileContents += combineArrayToString({
            object: lineItemKeys,
            columnDelimiter: columnDelimiter,
            lineDelimiter: lineDelimiter
        }).replace('type' + columnDelimiter, 'D' + columnDelimiter);
    }

    // Generate invoice data
    object.forEach(function(line) {
        var header = line['header'];
        var items  = Object.values(line['lineItems']);

        // Append header contents
        fileContents += combineArrayToString({
            object: header,
            columnDelimiter: columnDelimiter,
            lineDelimiter: lineDelimiter
        });

        // Append line items contents
        items.forEach(function(item) {
            fileContents += combineArrayToString({
                object: item,
                columnDelimiter: columnDelimiter,
                lineDelimiter: lineDelimiter
            });
        });
    });

    return fileContents;
}

function combineArrayToString (args) {
    var object = Object.values(args.object) || null;
    var columnDelimiter = args.columnDelimiter || ',';
    var lineDelimiter = args.lineDelimiter || '\n';
    var result = object.join(columnDelimiter);

    return result + lineDelimiter;
}

function placeholderReplace(string) {
    // Numbers
    string = string.replace(/{#}/g, function() {
        return chance.integer({ min: 0, max: 9 });
    });

    // Letters
    string = string.replace(/{a}/g, function() {
        return chance.letter();
    });

    // Words
    string = string.replace(/{w}/g, function() {
        return chance.word();
    });

    // Special Characters
    string = string.replace(/{%}/g, function() {
        return chance.character({ symbols: true });
    });

    return string;
}

function downloadFile(args) {
    var fileName = args.fileName || 'export.txt';
    var fileContents = args.fileContents || null;
    var fileType = args.fileType || 'text/plain';
    
    // Create an invisible A element
    const a = document.createElement('a');
    a.style.display = 'none';
    document.body.appendChild(a);
  
    // Set the HREF to a Blob representation of the data to be downloaded
    a.href = window.URL.createObjectURL(
        new Blob([fileContents], { fileType })
    );
  
    // Use download attribute to set set desired file name
    a.setAttribute('download', fileName);
  
    // Trigger the download by simulating click
    a.click();
  
    // Cleanup
    window.URL.revokeObjectURL(a.href);
    document.body.removeChild(a);
}

$('.link-show-datagen').on('click', function () {
    $('.form-main').addClass('d-none');
    $('.form-datagen').addClass('d-none');
});

$('#link-show-ebppbu').on('click', function (e) {
    e.preventDefault();
    $('#form-datagen-ebppbu').removeClass('d-none');
});

$('.btn-hide-datagen').on('click', function (e) {
    e.preventDefault();
    $('.form-main').removeClass('d-none');
    $('.form-datagen').addClass('d-none');
});

$('#form-datagen-random').on('submit', function (e) {
    e.preventDefault();

    var random = placeholderReplace($('#textarea-gen').val());
    $('#textarea-get').val(random);
});

$('#form-datagen-ebppbu').on('submit', function (e) {
    e.preventDefault();    

    // Generate the raw EBPP BU object
    var exportObject = generateBatchUploadExportObject({
        merchantId: $('#input-mid').val(),
        invoiceCount: $('#input-invcount').val(),
        email: $('#input-email').val(),
        lineItemMin: $('#input-lineitemmin').val(),
        lineItemMax: $('#input-lineitemmax').val(),
        amountMax: $('#input-amountmax').val()
    });

    // For debugging purposes only
    // Log the raw object to the console
    console.log(exportObject);

    // Convert the raw object to CSV
    exportObject = ebppBatchUploadObjectToCsv({
        object: exportObject,
        columnDelimiter: '|'
    });

    // Download the CSV file
    downloadFile({
        fileName: 'ebppbu-' + chance.hash() + '.csv',
        fileContents: exportObject,
        fileType: 'text/csv'
    });
});