$(document).ready(function () {
    loadBrands();

    $('#brand').change(function () {
        loadModels($(this).val());
    });

    $('#model').change(function () {
        loadYears($(this).val());
    });

    $('#year').change(function () {
        loadEngines($('#model').val(), $(this).val());
    });

    $('#oilFinderForm').submit(function (e) {
        e.preventDefault();
        findOil();
    });
});

function loadBrands() {
    $.ajax({
        url: 'load_brands.php',
        type: 'GET',
        success: function (data) {
            $('#brand').html(data);
        }
    });
}

function loadModels(brandId) {
    $.ajax({
        url: 'load_models.php',
        type: 'GET',
        data: { brand: brandId },
        success: function (data) {
            $('#model').html(data);
        }
    });
}

function loadYears(modelId) {
    $.ajax({
        url: 'load_years.php',
        type: 'GET',
        data: { model: modelId },
        success: function (data) {
            $('#year').html(data);
        }
    });
}

function loadEngines(modelId, year) {
    $.ajax({
        url: 'load_engines.php',
        type: 'GET',
        data: { model: modelId, year: year },
        success: function (data) {
            $('#engine').html(data);
        }
    });
}

function findOil() {
    var engine = $('#engine').val();

    $.ajax({
        url: 'find_oil.php',
        type: 'GET',
        data: { engine: engine },
        success: function (data) {
            $('#result').html(data);
        }
    });
}
