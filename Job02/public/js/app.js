$(document).ready(function () {
  const tabs = $(".tab-item");
  const panes = $(".tab-pane");
  const tabActive = $(".tab-item.active");
  const line = $(".tabs-line");
  line.css({
    left: tabActive.position().left + "px",
    width: tabActive.outerWidth() + "px"
  });

  tabs.each(function (index) {
    let tab = $(this);
    let pane = panes.eq(index);

    tab.on("click", function () {
      $(".tab-item.active").removeClass("active");
      $(".tab-pane.active").removeClass("active");

      line.css({
        left: tab.position().left + "px",
        width: tab.outerWidth() + "px"
      });

      tab.addClass("active");
      pane.addClass("active");
    });
  });
})