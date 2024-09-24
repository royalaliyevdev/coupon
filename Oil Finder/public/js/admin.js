$(document).ready(function() {
    loadBrands();

    // Marka eklendiğinde
    $('#addBrandForm').submit(function(e) {
        e.preventDefault();
        const brandName = $('#brandName').val();
        $.post('../api/add_brand.php', { name: brandName }, function(response) {
            alert('Brand added!');
            loadBrands(); // Markalar güncelleniyor
            $('#brandName').val(''); // Formu temizliyoruz
        });
    });

    // Model eklendiğinde
    $('#addModelForm').submit(function(e) {
        e.preventDefault();
        const brandId = $('#brandSelect').val();
        const modelName = $('#modelName').val();
        const yearStart = $('#yearStart').val();
        const yearStop = $('#yearStop').val();
        if (brandId === "") {
            alert('Please select a brand first.');
            return;
        }

        $.post('../api/add_model.php', { brand_id: brandId, name: modelName, year_start: yearStart, year_stop: yearStop }, function(response) {
            alert('Model added!');
            loadModels(brandId); // Seçilen markaya göre modelleri güncelleyerek yükleme yapıyoruz
            $('#modelName').val(''); // Formu temizliyoruz
            $('#yearStart').val('');
            $('#yearStop').val('');
        });
    });

    // Motor eklendiğinde
    $('#addEngineForm').submit(function(e) {
        e.preventDefault();
        const modelId = $('#modelSelect').val();
        const engineName = $('#engineName').val();
        const oilCapacity = $('#oilCapacity').val();
        if (modelId === "") {
            alert('Please select a model first.');
            return;
        }

        $.post('../api/add_engine.php', { model_id: modelId, engine: engineName, oil_capacity: oilCapacity }, function(response) {
            alert('Engine added!');
            loadEngines(modelId); // Motorlar yükleniyor
            $('#engineName').val(''); // Formu temizliyoruz
            $('#oilCapacity').val('');
        });
    });

    // Markaları yükle
    function loadBrands() {
        $.get('../load_brands.php', function(data) {
            $('#brandSelect').html(data); // Dropdown'a markaları yükle
            $('#brandList').html(data);   // Markalar listesine ekle
        });
    }

    // Modelleri yükle
    function loadModels(brandId) {
        if (!brandId) {
            $('#modelSelect').html('<option value="">Select Model</option>');
            return;
        }
        $.ajax({
            url: '../load_models.php',
            type: 'GET',
            data: { brand: brandId }, // Seçilen marka ID'sini gönderiyoruz
            success: function (data) {
                $('#modelSelect').html(data); // Modelleri dropdown'a ekle
            }
        });
    }

    // Motorları yükle
    function loadEngines(modelId) {
        if (!modelId) {
            $('#engineList').html('<option value="">Select Engine</option>');
            return;
        }
        $.ajax({
            url: '../load_engines.php',
            type: 'GET',
            data: { model_id: modelId }, // Seçilen model ID'sini gönderiyoruz
            success: function (data) {
                $('#engineList').html(data); // Motorları dropdown'a ekle veya listede göster
            }
        });
    }

    // Marka değiştiğinde modelleri yükle
    $('#brandSelect').change(function () {
        const brandId = $(this).val();
        loadModels(brandId); // Seçilen markaya göre modelleri yükle
    });

    // Model değiştiğinde motorları yükle
    $('#modelSelect').change(function () {
        const modelId = $(this).val();
        loadEngines(modelId); // Seçilen modele göre motorları yükle
    });
});
