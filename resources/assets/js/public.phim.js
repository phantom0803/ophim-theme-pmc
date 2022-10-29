jQuery(document).ready(function () {
    var score_current = jQuery("#score_current").val();
    var hint_current = jQuery("#hint_current").val();
    jQuery("#hint").html(hint_current);
    jQuery("#score").html(score_current + " ĐIỂM");
    function scorehint(score) {
        var text = "";
        if (score == "1") {
            text = "Dở tệ";
        }
        if (score == "2") {
            text = "Dở";
        }
        if (score == "3") {
            text = "Không hay";
        }
        if (score == "4") {
            text = "Ko hay lắm";
        }
        if (score == "5") {
            text = "Bình thường";
        }
        if (score == "6") {
            text = "Xem được";
        }
        if (score == "7") {
            text = "Có vẻ hay";
        }
        if (score == "8") {
            text = "Hay";
        }
        if (score == "9") {
            text = "Rất hay";
        }
        if (score == "10") {
            text = "Hay tuyệt";
        }
        return text;
    }
    jQuery("#star").raty({
        half: false,
        number: 10,
        numberMax: 10,
        starOff: "/themes/pmc/libs/jquery-raty/images/star-off.png",
        starOn: "/themes/pmc/libs/jquery-raty/images/star-on.png",
        starHalf: "/themes/pmc/libs/jquery-raty/images/star-half.png",
        score: function () {
            return jQuery(this).attr("data-score");
        },
        mouseover: function (score, evt) {
            jQuery("#score").html(score + " ĐIỂM");
            jQuery("#hint").html(scorehint(score));
        },
        mouseout: function (score, evt) {
            var score_current = jQuery("#score_current").val();
            var hint_current = jQuery("#hint_current").val();
            jQuery("#hint").html(hint_current);
            jQuery("#score").html(score_current + " ĐIỂM");
        },
        click: function (score, evt) {
            if (!rated) {
                jQuery
                    .ajax({
                        url: URL_POST_RATING,
                        type: "POST",
                        headers: {
                            "Content-Type": "application/json",
                            "X-CSRF-TOKEN": document
                                .querySelector('meta[name="csrf-token"]')
                                .getAttribute("content"),
                        },
                        data: JSON.stringify({
                            rating: score,
                        }),
                    })
                    .done(function (data) {
                        toastr.success("Đánh giá của bạn đã được ghi nhận.");
                        rated = true;
                    });
            } else {
                toastr.info("Bạn đã đánh giá phim này rồi mà");
            }
        },
    });
    jQuery("#star").css("width", "200px");
    jQuery(".box-rating #hint").css("font-size", "12px");
});
var fx = {
    scrollTo: function (selector, scrollTime) {
        if (typeof scrollTime != "number" || scrollTime < 1000)
            var scrollTime = 1000;
        if (jQuery(selector).length == 0) {
            console.error(
                "Không xác định được selector: " +
                    selector +
                    " để tìm vị trí cuộn."
            );
            return false;
        }
        var boxOffset = jQuery(selector).offset();
        var currentScrollTop = jQuery(document).scrollTop();
        if (
            typeof boxOffset == "object" &&
            typeof currentScrollTop == "number" &&
            boxOffset.top != currentScrollTop
        ) {
            jQuery("body,html").animate(
                { scrollTop: boxOffset.top },
                scrollTime
            );
        } else {
            console.error("boxOffset:");
            console.log(boxOffset);
            console.error("currentScrollTop");
            console.log(currentScrollTop);
        }
    },
};
if (jQuery("#film-content-wrapper > #film-content").length > 0) {
    var contentElement = jQuery("#film-content-wrapper > #film-content")[0];
    jQuery(contentElement).css("max-height", "500px");
    jQuery(window).load(function () {
        if (
            typeof contentElement.scrollHeight == "number" &&
            contentElement.scrollHeight > 0
        ) {
            window._restoreContentHeight = currentContentHeight =
                contentElement.scrollHeight;
            window._flagContentHeight = "small";
            if (currentContentHeight > 800) {
                window._restoreContentHeight = currentContentHeight;
                window._flagContentHeight = "small";
                jQuery("#film-content-wrapper").append(
                    '<button class="expand-content" id="btn-expand-content">Hiển thị thêm</button>'
                );
                jQuery("#btn-expand-content").click(function () {
                    if (window._flagContentHeight == "small") {
                        if (
                            typeof contentElement.scrollHeight == "number" &&
                            contentElement.scrollHeight > 0
                        )
                            window._restoreContentHeight =
                                contentElement.scrollHeight;
                        jQuery(contentElement).height(
                            window._restoreContentHeight + "px"
                        );
                        window._flagContentHeight = "large";
                        jQuery("#btn-expand-content").text("Thu gọn nội dung");
                    } else {
                        fx.scrollTo("#film-content-wrapper", 300);
                        jQuery(contentElement).height("500px");
                        window._flagContentHeight = "small";
                        jQuery("#btn-expand-content").text("Hiển thị thêm");
                    }
                });
                jQuery(contentElement).css({
                    height: "500px",
                    "max-height": "none",
                });
            }
        }
    });
}
