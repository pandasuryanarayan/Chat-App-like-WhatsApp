document.addEventListener('click', function(event){
    var toggle = document.getElementById('toggle');
    var dropdown = document.getElementById('dropdown');
    
    var isClickInsideDropdown = toggle.contains(event.target) || dropdown.contains(event.target);
    
    if(!isClickInsideDropdown && dropdown.style.display === "block"){
        // Click is outside, hide it
        dropdown.style.display = "none";
    }

    var contextMenu = document.getElementById('contextMenu');
    if(event.target !== contextMenu && !contextMenu.contains(event.target)){
        hideContextMenu();
    }
});

function toggleDropdown(){
    var dropdown = document.getElementById('dropdown');
    dropdown.style.display = (dropdown.style.display === "block") ? "none":"block";
}

let clickedButton = null;

function newchat() {
    for(i=1;i<=1;i++){
    const name = prompt('Enter name:');
    if (name === null) {
            alert('Chat creation canceled.');
            return;
        }else if(name.trim() === ''){
            alert('Name Missing.');
            return;
        }

    const mobileNumber = prompt('Enter mobile number:');
    if (mobileNumber === null) {
        alert('Chat creation canceled.');
        return;
    }else if(mobileNumber.length !== 10){
        alert('Mobile number must be exactly 10 digits.');
        return;
    }


    alert(`New Chat Created\nName: ${name}\nMobile Number: ${mobileNumber}`);
    document.getElementById('people-container').innerHTML += `
                <button  mobile-id="${mobileNumber}" oncontextmenu="showContextMenu(event)" onclick="openChatPage(event, this)" class="people">
                    <input type="checkbox" class="checkbox" disabled>
                    <img src="https://rb.gy/sgk8em" class="peImg" width="40px" height="40px"/>
                    ${name}
                </button>`;

    // Send data to the PHP script using AJAX
    const xhr = new XMLHttpRequest();
    const url = 'newChat.php';
    const params = `name=${encodeURIComponent(name)}&mobileNumber=${encodeURIComponent(mobileNumber)}`;

    xhr.open('POST', url, true);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

    xhr.onreadystatechange = function () {
        if (xhr.readyState == 4 && xhr.status == 200) {
            console.log(xhr.responseText);
        }
    }

    xhr.send(params);
  }
}

function showContextMenu(event){
    event.preventDefault();

    var contextMenu = document.getElementById('contextMenu');

    contextMenu.style.left = event.clientX + 'px';
    contextMenu.style.top = event.clientY + 'px';

    contextMenu.style.display = 'block';

    clickedButton = event.target;
}

function deleteButton(){
    if(clickedButton && clickedButton.parentNode){
        // Get the ID or any other identifier of the item to delete
        const mobileNumber = clickedButton.getAttribute('mobile-id');

        console.log('Item ID to delete:', mobileNumber);

        // Create a new XMLHttpRequest
        const xhr = new XMLHttpRequest();
        const url = 'deleteChat.php';
        const params = `mobileNumber=${encodeURIComponent(mobileNumber)}`;

        // Configure the request
        xhr.open('POST', url, true);
        xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

        // Define the callback function to handle the response
        xhr.onreadystatechange = function () {
            if (xhr.readyState == 4 && xhr.status == 200) {
                console.log('Response from server:', xhr.responseText);

                // Try to remove the item from the DOM
                if(clickedButton.parentNode) {
                    clickedButton.parentNode.removeChild(clickedButton);
                    console.log('Item removed from the DOM');
                } else {
                    console.log('Parent node is missing');
                }
            }
        }

        // Send the request with parameters
        xhr.send(params);
    } else {
        console.log('Clicked button or its parent node is missing');
    }

    hideContextMenu();
}


function hideContextMenu(){
    var contextMenu = document.getElementById('contextMenu');
    contextMenu.style.display = 'none';
}

function activateAllCheckboxes(){
    var checkboxes = document.querySelectorAll('.checkbox');
    var peoplebtns = document.querySelectorAll('.people');
    var namearea = document.querySelector('span');
    var peopleContainer = document.getElementById('people-container');
    var isPeople = peopleContainer.getElementsByClassName('people');

    if (isPeople.length >= 1) {
        namearea.style.display = "none";

        var checkboxConfirm = document.getElementById('chkConfirm');
        checkboxConfirm.innerHTML = `<button onclick="" id="chkConfirmbtn"> Confirm </button>`;
        checkboxConfirm.style.display = "block";

        checkboxes.forEach(function(checkbox){
        checkbox.style.display = "block";
        checkbox.style.cursor = "pointer";
        checkbox.disabled = false;
        });

        peoplebtns.forEach(function(peoplebtn){
            peoplebtn.onclick = "";
        });
    
    } else {
        alert('No People exists');
    }
}

function DirectMessage(){
    document.getElementById('send-message').style.display = 'block';
}

function closeDirectMessage(){
    document.getElementById('send-message').style.display = 'none';
}

function sendMessage(){
    return null; // Changes needed. Not fully implemented.
}

function openSettingsModal() {
    document.getElementById('settings-modal').style.display = 'block';
}

function toggleNav() {
    var sidebar = document.getElementById("sidebar");
    var main = document.getElementById('main');
    var AppName = document.getElementById('app-name');
    
    if (sidebar.style.width === "0px" || sidebar.style.width === "") {
        sidebar.style.width = "25%";
        main.style.marginLeft = "25%";
        AppName.style.marginLeft = "25%";
    } else {
        sidebar.style.width = "0";
        main.style.marginLeft = "0";
        AppName.style.marginLeft = "0px";
    }
}

function closeSettingsModal() {
    document.getElementById('settings-modal').style.display = 'none';
}

function openChatPage(event,target){
    clickedButton = target;
    if(clickedButton && clickedButton.parentNode){
        const mobileNumber = clickedButton.getAttribute('mobile-id');

        console.log('Mobile-Number:', mobileNumber);

        // Create a new XMLHttpRequest
        const xhr = new XMLHttpRequest();
        const url = 'chatDetails.php';
        const params = `mobileNumber=${encodeURIComponent(mobileNumber)}`;

        // Configure the request
        xhr.open('POST', url, true);
        xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

        // Define the callback function to handle the response
        xhr.onload = function () {
            if (xhr.readyState == 4 && xhr.status == 200) {
                try {
                    const response = JSON.parse(xhr.responseText);
                    if (response.name) {
                        updatePersonName(response.name);
                        window.location.href = 'chatDetails.html';
                    } else {
                        console.log('Name not found in the server response.');
                    }
                } catch (error) {
                    console.error('Error parsing server response:', error);
                }
            }else{
                console.log('Error from server:', xhr.statusText);
            }
        }

        // Send the request with parameters
        xhr.send(params);
    } else {
        console.log('Clicked button or its parent node is missing');
        console.log(event.target);
    }
    //window.location.href = "chatDetails.php";
}

function updatePersonName(name) {
    const personNamePlaceholder = document.getElementById('personNamePlaceholder');
    if (personNamePlaceholder) {
        personNamePlaceholder.textContent = name;
    }
}

function updateProfileImage() {
    const imageInput = document.getElementById('imageInput');
    const imageUrl = imageInput.value.trim();
    
    if (imageUrl !== '') {
        document.getElementById('img1').src = imageUrl;
        closeSettingsModal();
    } else {
        alert('Please enter a valid image URL.');
    }
}