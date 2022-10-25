function checkEmpty(){
  var img = document.getElementById('fileToUpload').value;
  if(img == ''){
    alert('Please upload an image');
    return false;
  }
  return true;
}