//autocomplete using awesomplete
addLoadListener(initAwesomplete);

function initAwesomplete(){
  var input = document.getElementById("awesomplete");
  // var awesomplete = new Awesomplete(input);
  var value = input.value;
  
  var awesomplete = new Awesomplete(input);
  input.onkeyup = function(e){
    var code = (e.keyCode || e.which);

    if(code === 37 || code === 38 || code === 39 || code === 40 || code === 27 || code === 13){
      return false;
    }else{

      var xhr = getXHR();
      var value = this.value;
        xhr.open("GET", siteUrl + "ajax/getSuggestions/" + value, true);
        xhr.onreadystatechange = function()
        {
          if (xhr.readyState ==4)
          {
            if (xhr.status ==200 || xhr.status ==304)
            {
              // response = xhr.responseText; // or xhr.responseXML;

              var list = JSON.parse(xhr.responseText).map(function(i) { return i; });
              awesomplete.list = list;
                awesomplete.data = function(i, input){
                  return { label: i.level, value: i.value };
                }
            }
          }
        };
        xhr.send();
      
    }
  }

  input.addEventListener('awesomplete-selectcomplete', function(){
    var newBusinessInfo = document.getElementById('newBusinessInfo');
    var existingBusiness = document.getElementById('existingBusiness');
    var mapContainer = document.getElementById('mapContainer');
    mapContainer.style.display = "none";
    newBusinessInfo.style.display = "none";
    existingBusiness.style.display = "block";

    window.location = siteUrl + "business/recommend/" + this.value;

    // var xhr = new XMLHttpRequest();
    // xhr.open('GET', siteUrl + "ajax/getBusinessById/" + value, true);
    // xhr.onreadystatechange = function()
    // {
    //   if(xhr.readyState == 4){
    //     if(xhr.status == 200 || xhr.status == 304)
    //     {
    //       existingBusiness.querySelector("#businessInfo").innerHTML = xhr.response;
    //     }
    //   }
    // };
    // xhr.send();
  });
}


//Load Listener 
function addLoadListener(fn)
{
  if(typeof window.addEventListener != 'undefined')
  {
    window.addEventListener('load', fn, false);
  }
  else if(typeof document.addEventListener != 'undefined')
  {
    document.addEventListener('load', fn, false);
  }
  else if(typeof window.attachEvent != 'undefined')
  {
    window.attachEvent('onload', fn);
  }
  else
  {
    var oldfn = window.onload;
    if (typeof window.onload != 'function')
    {
      window.onload = fn;
    }
    else
    {
      window.onload = function()
      {
        oldfn();
        fn();
      };
    }
  }
}