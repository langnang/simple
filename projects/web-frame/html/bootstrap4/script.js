const iFrameOnLoad = (element) => {
  console.log(`iFrameOnLoad`, element);
  var ifm = document.getElementById(element.id);
  var subWeb = document.frames ? document.frames[iframe.id].document : ifm.contentDocument;
  if (ifm != null && subWeb != null) {
    var ifmHeight = subWeb.body.scrollHeight;
    var ifmWidth = subWeb.body.scrollWidth;
    if (ifmHeight < 400) {
      ifm.height = 400;
      ifm.width = ifmWidth;
    } else {
      ifm.height = ifmHeight;
      ifm.width = ifmWidth;
    }

  }
}

$(document).on('click', '.list-group-item', function (element) {
  console.log(`click .list-group-item`, element)
  const src = $(element.target).attr('data-src');
  console.log(`click .list-group-item`, src)
  $('#iframe').attr('src', src)
  console.log($(element.target).siblings().removeClass('active'))
  $(element.target).siblings().removeClass('active')
  $(element.target).addClass('active')
})