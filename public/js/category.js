//require('./bootstrap');

var categoryInputDiv = document.getElementById('categoriesDiv');
var categoryInput = document.getElementById('categoriesInput');
var categoryChoiceList = document.getElementById('category-choices');
var newCategoryInput = document.getElementById('add-category-input');
var classStyle = "inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500";
var classChosen = " bg-indigo-200";

function addCategory(categoryId, categoryName){
    var node = createNode('span', 'btn btn-success ' + classStyle + classChosen, 'id ' + categoryId, 'resetChosenCategory(' + categoryId + ', \'' + categoryName + '\')', categoryName);
    categoryInputDiv.appendChild(node);
    var choice = createChoiceOptionForSelect(categoryId);
    categoryInput.appendChild(choice);
    removeCategoryFromChoiceList(categoryId);
}

function removeCategoryFromChoiceList(categoryId){
    var categoryButton = document.getElementById('cat ' + categoryId);
    categoryButton.remove();
}

function resetChosenCategory(categoryId, categoryName){
    var chosenCategory = document.getElementById('id ' + categoryId);
    chosenCategory.remove();
    var node = createNode('button', 'btn btn-outline-primary ' + classStyle, 'cat ' + categoryId, 'addCategory('+categoryId+', \'' +categoryName +'\')', categoryName)
    node.setAttribute('type', 'button');
    document.getElementById('cat-option ' + categoryId).remove();
    categoryChoiceList.appendChild(node);
}

function createNode(element, className, idName, onClickFunction, text){
    var node = document.createElement(element);
    var text = document.createTextNode(text);
    node.setAttribute('class', className);
    node.setAttribute('id', idName);
    node.setAttribute('onClick', onClickFunction);
    node.appendChild(text);
    return node;
}

function createChoiceOptionForSelect(categoryId){
    var node = document.createElement('option');
    node.setAttribute('value', categoryId);
    node.setAttribute('id', 'cat-option ' + categoryId);
    node.setAttribute('selected', '');
    return node;
}

function addNewCategory(){
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if(this.readyState == 4 && this.status == 201){
            addCategoryToChoiceList(JSON.parse(xhttp.responseText));
            newCategoryInput.value = '';
        }
    }
    xhttp.open('POST', '/category', true);
    xhttp.setRequestHeader('X-CSRF-TOKEN', $('meta[name="csrf-token"]').attr('content'));
    xhttp.setRequestHeader('Content-type', "application/x-www-form-urlencoded");
    xhttp.send("name=" + newCategoryInput.value);
}

function addCategoryToChoiceList(categoryObj){
    var node = createNode('button', 'btn btn-outline-primary ' + classStyle, 'cat ' + categoryObj.id, 'addCategory('+categoryObj.id+', \'' +categoryObj.name +'\')', categoryObj.name);
    categoryChoiceList.appendChild(node);
}

function filterPostsByCategory(categoryId){
    var contentDiv = document.getElementById('contentDiv');
    var clickedButton = document.getElementById('cat ' + categoryId);
    var url = '';
    if(clickedButton.getAttribute('class').includes('primary')){
        clickedButton.setAttribute('class', 'category btn btn-light ' + classStyle);
        url = '/';
    } else {
        clearOtherButtons(clickedButton);
        url = '/category/' + categoryId + '/items';
    }
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if(this.readyState == 4 && this.status == 200){
            contentDiv.innerHTML = this.response;
        }
    }
    xhttp.open('GET', url, true);
    xhttp.setRequestHeader('X-CSRF-TOKEN', $('meta[name="csrf-token"]').attr('content'));
    xhttp.setRequestHeader("X-Requested-With", "XMLHttpRequest");
    xhttp.send();
}

function clearOtherButtons(button){
    activeButtons = document.getElementsByClassName('category btn btn-primary ' + classStyle);
    if(activeButtons[0]){
        for(item of activeButtons) {
            item.setAttribute('class', 'category btn btn-light ' + classStyle);
        }
    }
    button.setAttribute('class', 'category btn btn-primary ' + classStyle);
}

function removeDuplicateCategories(){
    let chosenCategories = document.getElementsByClassName("category-chosen " + classStyle + classChosen);
    for(category of chosenCategories){
        removeCategoryFromChoiceList(category.id.slice(3));
    }
}

removeDuplicateCategories();
