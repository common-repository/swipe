var parent;

function doTests(p){
  
   parent = document.getElementById(p);

  createTests(newTest);

}



function newTest(text, options){

  var testbox = document.createElement("div");

  testbox.className = "testbox";



  var format = (typeof options !== "undefined" && options.format) || "auto";



  testbox.innerHTML = '\
    <svg class="barcode"/>';



  try{

    JsBarcode(testbox.querySelector('.barcode'), text, options);

  }

  catch(e){

    testbox.className = "errorbox";

    testbox.onclick = function(){

      throw e;

    }

  }



  parent.appendChild(testbox);

}
