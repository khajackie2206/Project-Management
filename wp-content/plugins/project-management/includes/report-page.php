
<?php
$members = (array) get_post_meta(get_the_ID(), '_members', true);
// var_dump($members);
// die;
$members_details = (array)get_post_meta(get_the_ID(), '_members_details', true);

?>

<!-- Link CSS của DataTables -->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.11.2/datatables.min.css" />

<!-- Link JS của DataTables -->
<script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.11.2/datatables.min.js"></script>

<link rel="stylesheet" href="<?= PROJECT_MANAGEMENT_URL ?>/assets/css/style.css">

<script>
    jQuery(document).ready(function ($) {
        // Khởi tạo DataTables cho bảng
        $('#members-details-table').DataTable({
            "paging": true, // Cho phép phân trang
            "lengthChange": false, // Không cho phép thay đổi số lượng bản ghi trên một trang
            "searching": false, // Không cho phép tìm kiếm
            "ordering": false, // Không cho phép sắp xếp
            "info": false, // Không hiển thị thông tin bảng (Ví dụ: Showing 1 to 10 of 57 entries)
            "autoWidth": false, // Không tự động tính toán chiều rộng cột
            "data": <?php echo json_encode($members_details); ?>, // Dữ liệu của bảng
            "columns": [
                { "data": "image" }, // Cột image
                { "data": "name" }, // Cột name
                { "data": "position" } // Cột position
            ],
            "columnDefs": [
                { // Tùy chỉnh hiển thị cột image
                    "targets": 0,
                    "render": function (data, type, row, meta) {
                        return '<img src="' + data + '" width="50" />';
                    }
                }
            ]
        });
    });

</script>

<!-- Hiển thị bảng members detail -->
<div class="form-group">
    <table id="members_details_table" class="table">
        <thead>
            <tr>
                <th>Image</th>
                <th>Name</th>
                <th>Position</th>
                <th>Level</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($members_details as $member): ?>
       
                <?php if (!is_null($member) && is_array($member)): ?>
                    <?php

                    // Truy xuất thông tin chi tiết user dựa trên id
                    $user = get_user_by('id', $member['member_id']);
                    // var_dump($user);
                    // die;
                    // Lấy đường dẫn hình ảnh (thumbnail) của user
                    $user_thumbnail_url = get_avatar_url($member['member_id'], array('size' => 'thumbnail'));
                    ?>
                    <input type="hidden" value="<?= esc_attr($member['member_id']) ?>" name="members_id[]">
                    <tr>
                        <td>
                            <img src="<?= esc_attr($user_thumbnail_url) ?>" />
                        </td>
                        <td>
                            <?= esc_attr($user->display_name) ?>
                        </td>
                        <td>
                            <input type="text" value="<?= esc_attr($member['member_position']) ?>" name="member_positions[]">
                        </td>
                        <td>
                            <input type="text" value="<?= esc_attr($member['member_level']) ?>" name="member_levels[]">
                        </td>
                    </tr>
                <?php endif; ?>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>