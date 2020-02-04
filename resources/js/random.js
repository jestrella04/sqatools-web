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

function ebppbuInvoiceCollection(args) {
    var format = args.format;
    var merchantId = args.merchantId;
    var invoiceCount = parseInt(args.invoiceCount);
    var email = args.email;
    var lineItemMin = parseInt(args.lineItemMin);
    var lineItemMax = parseInt(args.lineItemMax);
    var amountMax = args.amountMax;

    var invoiceCollection = {};

    for (var i = 0; i < invoiceCount; i++) {
        if ('stf' == format) {
            invoiceCollection[i] = ebppbuStandardInvoice({
                merchantId: merchantId,
                email: email,
                lineItemMin: lineItemMin,
                lineItemMax: lineItemMax,
                amountMax: amountMax
            });
        } else if ('ktf' == format) {
            invoiceCollection[i] = ebppbuKellyTractorInvoice({
                email: email,
                amountMax: amountMax
            });
        }        
    }

    return invoiceCollection;    
}

function ebppbuStandardInvoice(args) {
    var merchantId = args.merchantId;
    var email = args.email;
    var lineItemMin = parseInt(args.lineItemMin);
    var lineItemMax = parseInt(args.lineItemMax);
    var amountMax = args.amountMax;
    var currentDate = new Date();
    var formatDate = ('0' + (currentDate.getMonth() + 1)).slice(-2) + currentDate.getDate().toString() + currentDate.getFullYear().toString();
    var invoice = {};

    invoice.header = {};
    invoice.header.type = 'H';
    invoice.header.customerNumber = 'CU-' + chance.string({ length: 7, pool: '0123456789' });
    invoice.header.customerName = chance.name();
    invoice.header.customerAddressLine1 = chance.address();
    invoice.header.customerAddressLine2 = '';
    invoice.header.customerCity = chance.city();
    invoice.header.customerState = chance.state();
    invoice.header.customerZip = chance.zip();
    invoice.header.invoiceCreditTerms = '';
    invoice.header.creditManagerName = '';
    invoice.header.accountsReceivableBalance = '';
    invoice.header.reserved1 = '';
    invoice.header.shipToCustomer = '';
    invoice.header.shipToName = '';
    invoice.header.shipToAddressLine1 = '';
    invoice.header.shipToAddressLine2 = '';
    invoice.header.shipToCity = '';
    invoice.header.shipToState = '';
    invoice.header.shipToZip = '';
    invoice.header.reserved2 = '';
    invoice.header.reserved3 = '';
    invoice.header.purchaseOrderNumber = '';
    invoice.header.reserved4 = '';
    invoice.header.emailAddress = placeholderReplace(email);
    invoice.header.merchantId = merchantId;

    invoice.lineItems = {};

    var lineItemCount = chance.integer({ min: lineItemMin, max: lineItemMax });
    var lineItemInvoice = 'BU-' + chance.string({ length: 10, pool: '0123456789' });

    for (var l = 0; l < lineItemCount; l++) {
        var lineItemAmount = chance.dollar({ max: amountMax }).replace('$', '');
        var description = chance.age() + ' ' + chance.capitalize(chance.word()) + ' ' + chance.animal();

        invoice.lineItems[l] = {};
        invoice.lineItems[l].type = 'D';
        invoice.lineItems[l].invoiceNumber = lineItemInvoice;
        invoice.lineItems[l].salesOrderNumber = '';
        invoice.lineItems[l].lineItemNumber = parseInt(l) + 1;
        invoice.lineItems[l].typeOfDocument = 'IN';
        invoice.lineItems[l].typeOfAmount = '+';
        invoice.lineItems[l].shippingDate = '';
        invoice.lineItems[l].purchaseOrderNumber = '';
        invoice.lineItems[l].partNumber = '';
        invoice.lineItems[l].partDescription = description;
        invoice.lineItems[l].orderQuantity = '1.00';
        invoice.lineItems[l].shipmentQuantity = '1.00';
        invoice.lineItems[l].backOrderedQuantity = 0;
        invoice.lineItems[l].individualUnitPrice = lineItemAmount;
        invoice.lineItems[l].discountPercentage = 0;
        invoice.lineItems[l].extendedPrice = lineItemAmount;
        invoice.lineItems[l].taxAmount = 0;
        invoice.lineItems[l].orderDate = '';
        invoice.lineItems[l].invoiceDueDate = formatDate;
        invoice.lineItems[l].invoiceGeneratedDate = formatDate;
        invoice.lineItems[l].invoicePdfFilename = '';
    }

    return invoice;
}

function ebppbuKellyTractorInvoice(args) {
    var email = args.email;
    var amountMax = args.amountMax;
    var currentDate = new Date();
    var formatDate = ('0' + (currentDate.getMonth() + 1)).slice(-2) + '/' + currentDate.getDate().toString() + '/' + currentDate.getFullYear().toString();
    var invoiceAmount = chance.dollar({ max: amountMax }).replace('$', '');
    var invoice = {};

    invoice.email = placeholderReplace(email);
    invoice.customerCode = 'CU-' + chance.string({ length: 7, pool: '0123456789' });
    invoice.customerName = chance.name();
    invoice.customerAddress = chance.address();
    invoice.customerCity = chance.city();
    invoice.customerState = chance.state();
    invoice.customerZip = chance.zip();
    invoice.paymentTermId = '';
    invoice.collector = '';
    invoice.employeeName2 = '';
    invoice.transactionDate = formatDate;
    invoice.voucher = '';
    invoice.invoiceNumber = 'BU-' + chance.string({ length: 10, pool: '0123456789' });
    invoice.invoiceDescription = chance.age() + ' ' + chance.capitalize(chance.word()) + ' ' + chance.animal();
    invoice.originalAmount = invoiceAmount;
    invoice.taxAmount = 0;
    invoice.netAmount1 = invoiceAmount;
    invoice.settleAmount = 0;
    invoice.netAmount2 = invoiceAmount;
    invoice.transactionType = '';

    return invoice;
}

function ebppbuInvoiceCollectionToCsv(args) {
    var format = args.format || null;
    var object = Object.values(args.object) || null;
    var columnDelimiter = args.columnDelimiter || ',';
    var lineDelimiter = args.lineDelimiter || '\n';
    var includeHeader = args.includeHeader || true;
    var fileContents = '';

    if (null === object || null === format) {
        return fileContents;
    }

    if ('stf' == format) {
        // Set the proper column delimiter
        columnDelimiter = '|';

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
    } else if ('ktf' == format) {
        // Generate header lines
        if (includeHeader) {
            var headerKeys = Object.keys(object[0]);

            // Append header column titles (EBPP BU ignores the first line)
            fileContents += combineArrayToString({
                object: headerKeys,
                columnDelimiter: columnDelimiter,
                lineDelimiter: lineDelimiter
            });
        }

        // Generate invoice data
        object.forEach(function(line) {            
            fileContents += combineArrayToString({
                object: line,
                columnDelimiter: columnDelimiter,
                lineDelimiter: lineDelimiter
            });
        });
    }
    
    return fileContents;
}

function level3Information (args) {
    var lineItems = args.lineItems || 1;
    var lineItemAmountMax = args.lineItemAmountMax || 999.99
    var level3Object = {};
    var currentDate = new Date();
    var formatDate = ('0' + (currentDate.getMonth() + 1)).slice(-2) + currentDate.getDate().toString() + currentDate.getFullYear().toString();

    // Generate header
    level3Object.LevelIIIData = {}
    level3Object.LevelIIIData.Header = {};
    level3Object.LevelIIIData.Header.CustomerCode = 'CU-' + chance.string({ length: 7, pool: '0123456789' });
    level3Object.LevelIIIData.Header.ShiptofromZIPcode = chance.zip();
    level3Object.LevelIIIData.Header.Destinationcountrycode = '840';
    level3Object.LevelIIIData.Header.VATinvoicereferencenumber = '1';
    level3Object.LevelIIIData.Header.VATtaxamountrate = '0.07';
    level3Object.LevelIIIData.Header.Freightshippingamount = '0';
    level3Object.LevelIIIData.Header.Dutyamount = '0';
    level3Object.LevelIIIData.Header.Orderdate = formatDate;
    level3Object.LevelIIIData.Header.Discountamount = '0';

    // Generate line items
    level3Object.LevelIIIData.Products = {};
    level3Object.LevelIIIData.Products.product = [];

    for (var i = 0; i < lineItems; i++) {
        var lineItemAmount = chance.dollar({ max: lineItemAmountMax }).replace('$', '');
        var lineItemQuantity = chance.integer({ min: 1, max: 10 });
        var lineItemTotal = (parseFloat(lineItemAmount) * parseInt(lineItemQuantity)).toFixed(2);
        var lineItemInfo = {};

        // Generate line item information
        lineItemInfo.ItemCommodityCode = 'C2584';
        lineItemInfo.ItemDescription = chance.sentence();
        lineItemInfo.ItemSequenceNumber = i + 1;
        lineItemInfo.LineItemTotal = lineItemTotal;
        lineItemInfo.ProductCode = 'L3-' + chance.string({ length: 10, pool: '0123456789' });;
        lineItemInfo.Quantity = lineItemQuantity;
        lineItemInfo.Selected = 'true';
        lineItemInfo.UnitCost = lineItemAmount;
        lineItemInfo.UnitofMeasureCode = 'CCT';

        // Add to the level III object
        level3Object.LevelIIIData.Products.product.push(lineItemInfo);
    }

    // Generate notes
    level3Object.LevelIIIData.Notes = {};
    level3Object.LevelIIIData.Notes.Note = [];
    level3Object.LevelIIIData.Notes.Note.push(chance.sentence());

    return level3Object;
}

$('.btn-hide-datagen, .link-hide-datagen').on('click', function (e) {
    e.preventDefault();
    $('.form-datagen').addClass('d-none');
});

$('#link-show-string').on('click', function (e) {
    e.preventDefault();
    $('#form-datagen-string').removeClass('d-none');
});

$('#link-show-ebppbu').on('click', function (e) {
    e.preventDefault();
    $('#form-datagen-ebppbu').removeClass('d-none');
});

$('#link-show-level3').on('click', function (e) {
    e.preventDefault();
    $('#form-datagen-level3').removeClass('d-none');
});

$('#form-datagen-string').on('submit', function (e) {
    e.preventDefault();

    var random = placeholderReplace($('#textarea-gen').val());
    $('#textarea-get').val(random);
});

$('#input-ebppbu-format').on('change', function () {
    var currentVal = $(this).val();

    if ('stf' == currentVal) {
        // Enable the line item fields
        $('#input-ebppbu-mid').attr('disabled', false);
        $('#input-ebppbu-lineitemmin').attr('disabled', false);
        $('#input-ebppbu-lineitemmax').attr('disabled', false);

        // Unhide the fields
        $('#input-ebppbu-mid').parent().parent().removeClass('d-none');
        $('#input-ebppbu-lineitemmin').parent().parent().removeClass('d-none');
        $('#input-ebppbu-lineitemmax').parent().parent().removeClass('d-none');
    } else {
        // Disable the line item fields
        $('#input-ebppbu-mid').attr('disabled', 'disabled');
        $('#input-ebppbu-lineitemmin').attr('disabled', 'disabled');
        $('#input-ebppbu-lineitemmax').attr('disabled', 'disabled');

        // Hide the fields
        $('#input-ebppbu-mid').parent().parent().addClass('d-none');
        $('#input-ebppbu-lineitemmin').parent().parent().addClass('d-none');
        $('#input-ebppbu-lineitemmax').parent().parent().addClass('d-none');
    }
});

$('#form-datagen-ebppbu').on('submit', function (e) {
    e.preventDefault();
    var exportFormat = $('#input-ebppbu-format').val();

    // Generate the raw EBPP BU object
    var exportObject = ebppbuInvoiceCollection({
        format: exportFormat,
        merchantId: $('#input-ebppbu-mid').val(),
        invoiceCount: $('#input-ebppbu-invcount').val(),
        email: $('#input-ebppbu-email').val(),
        lineItemMin: $('#input-ebppbu-lineitemmin').val(),
        lineItemMax: $('#input-ebppbu-lineitemmax').val(),
        amountMax: $('#input-ebppbu-amountmax').val()
    });

    // Convert the raw object to CSV
    exportObject = ebppbuInvoiceCollectionToCsv({
        format: exportFormat,
        object: exportObject
    });

    // Download the CSV file
    downloadFile({
        fileName: 'ebppbu-' + exportFormat + '-' + chance.hash() + '.csv',
        fileContents: exportObject,
        fileType: 'text/csv'
    });
});

$('#form-datagen-level3').on('submit', function (e) {
    e.preventDefault();

    var lineItems = $('#input-level3-lineitems').val();
    var lineItemAmountMax = $('#input-level3-amountmax').val();
    var level3Object = level3Information({
        lineItems: lineItems,
        lineItemAmountMax: lineItemAmountMax
    });

    // Create x2js instance with default config
    var x2js = new X2JS();
    var xml = x2js.json2xml_str(level3Object);

    $('#input-level3-xml').val(xml);
});