(function () {
  "use strict";

  fetch("/storage/data/main.json")
    .then(res => res.json())
    .then(res => {

      console.log(`fetch`, res)
    })

})();