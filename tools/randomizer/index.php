<!DOCTYPE html>
<html lang="en">

<?php
	$app = [
		'id' => 'randomizer',
		'name' => 'Randomizer',
		'description' => 'Random data generator for CenPOS apps',
		'logo' => 'qa.png',
		'logo_type' => 'image/png',
		'jquery' => false,
	];

	require '../../resources/views/header.php';
?>

<body id="app-randomizer">
	<div class="container">
        <div id="list-datagen">
            <div class="text-center">
                <legend>Available Data Generators</legend>
            </div>
            
            <div class="list-group list-group-horizontal">
                <a href="#" class="list-group-item list-group-item-action link-hide-datagen text-center" id="link-show-string">Random String</a>
                <a href="#" class="list-group-item list-group-item-action link-hide-datagen text-center" id="link-show-ebppbu">EBPP Batch Upload</a>
                <a href="#" class="list-group-item list-group-item-action link-hide-datagen text-center" id="link-show-level3">Level III</a>
            </div>
        </div>

        <form class="form-help-text">
            <div class="form-group text-center">
                <small class="form-text text-muted">Use {#} as a placeholder for a random number [0-9].</small>
                <small class="form-text text-muted">Use {a} as a placeholder for a random character [a-z].</small>
                <small class="form-text text-muted">Use {w} as a placeholder for a random nonsense word.</small>
                <small class="form-text text-muted">Use {%} as a placeholder for a random special character.</small>
            </div>
        </form>
        
        <form id="form-datagen-string" class="form-datagen d-none">
            <fieldset>
                <legend>Random String Generator</legend>
            </fieldset>

            <div class="form-row">
                <div class="col">
                    <div class="form-group">
                        <textarea id="textarea-gen" class="form-control" rows="5" placeholder="Enter a collection of placeholders to generate a random string" required></textarea>
                    </div>
                </div>

                <div class="col">
                    <div class="form-group">
                        <textarea id="textarea-get" class="form-control" rows="5" disabled></textarea>
                    </div>
                </div>
            </div>
            
            <button id="button-get-random" class="btn btn-lg btn-primary">Generate String</button>
            <button type="cancel" class="btn btn-lg btn-danger btn-hide-datagen">Cancel</button>
        </form>

		<form id="form-datagen-ebppbu" class="form-datagen d-none">
            <fieldset>
                <legend>EBPP Batch Upload CSV Generator</legend>
            </fieldset>

            <div class="form-group row">
                <label for="input-ebppbu-format" class="col-sm-2 col-form-label">Format</label>

                <div class="col-sm-10">
                    <select class="form-control" id="input-ebppbu-format" required>
                        <option value="" selected disabled>-- SELECT --</option>
                        <option value="stf">Standard</option>
                        <option value="ktf">Kelly Tractor</option>
                    </select>
                </div>
            </div>
            
            <div class="form-group row ebppbu-stf d-none">
              <label for="input-ebppbu-mid" class="col-sm-2 col-form-label">Merchant ID</label>

              <div class="col-sm-10">
                    <input type="number" class="form-control" id="input-ebppbu-mid" required disabled>
              </div>
            </div>

            <div class="form-group row ebppbu-common d-none">
                <label for="input-ebppbu-email" class="col-sm-2 col-form-label">Email</label>

                <div class="col-sm-10">
                    <input type="email" class="form-control" id="input-ebppbu-email" required disabled>
                    <small class="form-text text-muted">You can use the predefined placeholders to generate a random unique email per invoice.</small>
                </div>
            </div>

            <div class="form-group row ebppbu-common d-none">
                <label for="input-ebppbu-invcount" class="col-sm-2 col-form-label"># of Invoices</label>

                <div class="col-sm-10">
                    <input type="number" class="form-control" id="input-ebppbu-invcount" step="1" min="1" value="100" required disabled>
                </div>
            </div>

            <div class="form-group row ebppbu-stf d-none">
                <label for="input-ebppbu-lineitemmin" class="col-sm-2 col-form-label">Line items min</label>

                <div class="col-sm-10">
                    <input type="number" class="form-control" id="input-ebppbu-lineitemmin" step="1" min="1" value="1" required disabled>
                </div>
            </div>

            <div class="form-group row ebppbu-stf d-none">
                <label for="input-ebppbu-lineitemmax" class="col-sm-2 col-form-label">Line items max</label>

                <div class="col-sm-10">
                    <input type="number" class="form-control" id="input-ebppbu-lineitemmax" step="1" min="1" value="10" required disabled>
                </div> 
            </div>

            <div class="form-group row ebppbu-common d-none">
                <label for="input-ebppbu-amountmax" class="col-sm-2 col-form-label">Amount max</label>

                <div class="col-sm-10">
                    <input type="number" class="form-control" id="input-ebppbu-amountmax" step="0.01" min="1" value="999.99" required disabled>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-10 offset-sm-2">
                    <button 
                        id="btn-submit-ebppbu-form" 
                        type="submit" 
                        class="btn btn-lg btn-primary">
                        Generate CSV
                    </button>

                    <button id="btn-cancel-ebppbu-form"
                        type="cancel" 
                        class="btn btn-lg btn-danger btn-hide-datagen">
                        Cancel
                    </button>
                </div>
            </div>
        </form>

        <form id="form-datagen-level3" class="form-datagen d-none">
            <fieldset>
                <legend>Level III Data XML Generator</legend>
            </fieldset>

            <div class="form-row">
                <div class="col">
                    <div class="form-group row">
                        <label for="input-ebppbu-invcount" class="col-sm-4 col-form-label"># of Line items</label>

                        <div class="col-sm-8">
                            <input type="number" class="form-control" id="input-level3-lineitems" step="1" min="1" value="10" required>
                        </div>
                    </div>
        
                    <div class="form-group row">
                        <label for="input-ebppbu-amountmax" class="col-sm-4 col-form-label">Max unit price (for line items)</label>

                        <div class="col-sm-8">
                            <input type="number" class="form-control" id="input-level3-amountmax" step="0.01" min="1" value="999.99" required>
                        </div>
                    </div>
                </div>

                <div class="col">
                    <div class="form-group">
                        <textarea class="form-control" id="input-level3-xml" rows="5" disabled></textarea>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-10 offset-sm-2">
                    <button type="submit" class="btn btn-lg btn-primary">Generate XML</button>
                    <button type="cancel" class="btn btn-lg btn-danger btn-hide-datagen">Cancel</button>
                </div>
            </div>
        </form>
	</div>

	<?php require '../../resources/views/footer.php' ?>
</body>
</html>
