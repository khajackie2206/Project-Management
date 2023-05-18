<!-- Link CSS và JS của Select2 -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://code.jquery.com/ui/1.13.0/jquery-ui.min.js"></script>
<link rel="stylesheet" href="https://code.jquery.com/ui/1.13.0/themes/base/jquery-ui.css">


<style>
    /* Tùy chỉnh select2 */
    .select2-container {
        width: 100% !important;
        margin: 0 !important;
        padding: 0 !important;
    }

    .select2-selection {
        height: auto !important;
        border: 1px solid #ced4da !important;
        border-radius: 4px !important;
    }

    .select2-selection__choice {
        background-color: #007bff !important;
        color: #fff !important;
    }

    .select2-selection__choice__remove {
        color: #fff !important;
        margin-right: 5px !important;
    }

    .select2-selection__choice__remove:hover {
        color: #fff !important;
    }
</style>
<div class="alignleft actions" style="margin-left: 30px;">
    <div class="alignleft actions">Start date:</div>
    <div class="alignleft actions">
        <input type="text" id="start_date_filter" name="start_date_filter" class="datepicker" />
    </div>
    <div class="alignleft actions" style="margin-left: 20px;">End date:</div>
    <div class="alignleft actions">
        <input type="text" id="end_date_filter" name="end_date_filter" class="datepicker" />
    </div>
    <input type="submit" name="" id="filter-date-submit" class="button" value="Filter date range" onclick="keepValue()">
</div>
<script>
    jQuery(document).ready(function($) {
        // Khởi tạo date picker cho 2 trường start_date và end_date
        $('.datepicker').datepicker({
            dateFormat: 'dd-mm-yy'
        });
    });
</script>
<script>
    function keepValue() {
        var startDate = document.getElementById('start_date_filter').value;
        var endDate = document.getElementById('end_date_filter').value;
        localStorage.setItem('startDate', startDate);
        localStorage.setItem('endDate', endDate);
    }

    // Lấy giá trị từ localStorage và gán lại cho input khi trang được tải lại
    window.addEventListener('DOMContentLoaded', function() {
        var startDate = localStorage.getItem('startDate');
        var endDate = localStorage.getItem('endDate');
        if (startDate) {
            document.getElementById('start_date_filter').value = startDate;
        }
        if (endDate) {
            document.getElementById('end_date_filter').value = endDate;
        }

        //then delete the localStorage
        localStorage.removeItem('startDate');
        localStorage.removeItem('endDate');
    });
</script>