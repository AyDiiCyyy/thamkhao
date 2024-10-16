$(document).ready(function () {
    function toggleStatus(button, statusType) {
        var itemId = button.data("id");
        var url = button.data("url");
        var csrfToken = $('meta[name="csrf-token"]').attr("content");
        $.ajax({
            url: url,
            type: "POST",
            data: {
                id: itemId,
                _token: csrfToken,
            },
            success: function (response) {
                var newStatus = statusType === "active" ? response.newStatus : response.newHot;
                button.data("status", newStatus);
                var buttonText;

                if(statusType === "active"){
                    if(newStatus == 1){
                        buttonText = "Hiển thị";
                    }else{
                        buttonText = "Ẩn";
                    }
                }

                if(statusType === "hot"){
                    if(newStatus == 1){
                        buttonText = "Nổi bật";
                    }else{
                        buttonText = "không";
                    }
                }

                button.text(buttonText);

                button.removeClass("btn-success btn-danger");
                var buttonClass = newStatus == 1 ? "btn-success" : "btn-danger";
                button.addClass(buttonClass);

                Swal.fire({
                    title: "Thành công!",
                    text: "Cập nhật trạng thái thành công!",
                    icon: "success",
                    confirmButtonText: "OK",
                });
            },
        });
    }

    function changeOrder(input) {
        var url = input.data("url");
        var itemId = input.data("id");
        var order = input.val();
        console.log(order);
        var csrfToken = $('meta[name="csrf-token"]').attr("content");
        $.ajax({
            url: url,
            type: "POST",
            data: {
                id: itemId,
                order: order,
                _token: csrfToken,
            },
            success: function (response) {
                Swal.fire({
                    title: "Số thứ tự đã được thay đổi",
                    icon: "success",
                    confirmButtonText: "OK",
                });
            }
        });
    }

// Event handler for toggling active status
    $(".toggle-active-btn").click(function () {
        toggleStatus($(this), "active");
    });

    // Event handler for toggling hot status
    $(".toggle-hot-btn").click(function () {
        toggleStatus($(this), "hot");
    });

    $(".changeOrder").change(function () {
        changeOrder($(this));
    })
});
