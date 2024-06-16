function passCheck() {
    var togglePassword = document.getElementById('togglePassword');
    var passwordInput = document.getElementById('passwordInput');

    if (togglePassword && passwordInput) { 
        if (passwordInput.type === 'password') {
          passwordInput.type = 'text';
        } else {
          passwordInput.type = 'password';
        }
    }
}

// Now not functional
/*
function signup(){
    var Name = document.getElementById('name').value;
    var MoNo = document.getElementById('moNO').value;
    var pass = document.getElementById('passwordInput').value;
    var form = document.getElementById('sf2');
    
    if(!Name && !MoNo && !pass){
        alert('Enter all details..');
    }else {
        if(Name === null || Name.trim() === ''){
            alert('Name Empty');
        }
        else if(MoNo.length !== 10 || pass.length < 8){
            alert('Mobile Number should be exactly 10 digits and password should be greater than 8');
        }else{
            form.action = 'signup.php';
            // window.location.href = 'index.html';
        }
    }
}
*/