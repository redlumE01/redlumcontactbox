document.addEventListener("DOMContentLoaded", function() {

  // ScreenCheck / Sets screen value
  let str = window.location.search,
      currentScreen = '';

  str.search("settings") > 0 ? currentScreen = 'settings' : currentScreen = 'edit';

  let fieldsetParent, fieldset,customCheckbox,uploadBtn,uploadInputField,uploadTableRow,currentSelectedRow,faLibRow,iconColorRow,iconColorRowBtn;

  if (currentScreen === "settings") {
    fieldsetParent = document.getElementById('wpbody-content'),
    fieldset =  document.getElementsByTagName('fieldset')[0],
    customCheckbox = document.getElementById('use_custom_icon'),
    uploadBtn = document.querySelector('.form-table tbody').children[4].querySelector('.button'),
    uploadInputField = document.querySelector('.form-table tbody').children[4].querySelector('#custom_icon'),
    uploadTableRow = document.querySelector('.form-table tbody').children[4],
    faLibRow = document.querySelector('.form-table tbody').children[1],
    iconColorRow = document.querySelector('.form-table tbody').children[2],
    iconColorRowBtn = document.querySelector('.form-table tbody').children[2].querySelector('input'),
    currentSelectedRow = document.querySelector('.form-table tbody').children[0];

  } else {
    fieldsetParent = document.getElementById('fontawesome_icon'),
    fieldset =  fieldsetParent.getElementsByTagName('fieldset')[0],
    customCheckbox = document.getElementById('redlum_contact_box_activate-custom-icon'),
    uploadBtn = fieldsetParent.querySelector('.form-table').children[0].children[4].querySelector('.button'),
    uploadInputField = fieldsetParent.querySelector('.form-table').children[0].children[4].querySelector('#redlum_media_upload'),
    uploadTableRow = fieldsetParent.querySelector('.form-table').children[0].children[4],
    currentSelectedRow = fieldsetParent.querySelector('.form-table').children[0].children[0],
    faLibRow = fieldsetParent.querySelector('.form-table').children[0].children[1],
    iconColorRow = fieldsetParent.querySelector('.form-table').children[0].children[2],
    iconColorRowBtn = iconColorRow.querySelector('input');

  }

  // Removes values
  fieldset.innerHTML = '';

  // Load button creation

  const loadMoreBtn = document.createElement('BUTTON');
  loadMoreBtn.setAttribute('type', 'button');
  loadMoreBtn.setAttribute('class', 'button');
  loadMoreBtn.innerHTML = 'load more icons';

  fieldsetParent.querySelector('.form-table').children[0].children[1].childNodes[1].appendChild(loadMoreBtn);

  // Create mega array

  const spreadableOne = Object.entries( window["___FONT_AWESOME___"].styles.fa),
        spreadableTwo = Object.entries( window["___FONT_AWESOME___"].styles.far),
        spreadableThree = Object.entries( window["___FONT_AWESOME___"].styles.fas);

   spreadableOne.forEach(function(icon) {
     icon.push({classname: 'fa fa-' + icon[0],});
  });

  spreadableTwo.forEach(function(icon) {
    icon.push({classname: 'far fa-' + icon[0],});
  });

  spreadableThree.forEach(function(icon) {
    icon.push({classname: 'fas fa-' + icon[0],});
  });

  // Combine all arrays

  const entries = spreadableOne.concat(spreadableTwo).concat(spreadableThree);

  // Set Parse indexes

  let parseIndex = 0, parseLength = 50;

  // Draw current selected icon on post edit

  let apiUrl = '';

  switch(currentScreen) {
    case 'edit':
      apiUrl = window.wpApiSettings.root + 'wp/v2/redlum_contact_box/' + document.getElementById("post_ID").value;
      break;
    case 'settings':
      apiUrl = window.wpApiSettings.root + 'redlum_contact_box/settings';
      break;
  }

  fetch(apiUrl)
    .then(
      response => response.json()
    )
    .then(data => {
      let iconInputField;

      switch(currentScreen) {
        case 'edit':
          apiUrl = window.wpApiSettings.root + 'wp/v2/redlum_contact_box/' + document.getElementById("post_ID").value,
          iconInputField = document.getElementById('redlum_contact_box_current_font_awesome_icon');
          iconInputField.value = data['redlum_contact_box_font_awesome_icon'];
          break;

        case 'settings':
          apiUrl = window.wpApiSettings.root + 'redlum_contact_box/settings';
          iconInputField = document.getElementById('current_selected_icon');
          iconInputField.setAttribute('value', data['current_selected_icon']);

          break;
      }

      (() => {
        const icon = document.createElement("I");
        icon.className = iconInputField.value;
        fieldsetParent.querySelector('.form-table tr td').appendChild(icon);
      })()

    })
    .catch(error => console.error(error));


  function getIcons(parseIndex,parseLength){

      function createIcon(i){
        const label = document.createElement("LABEL"),
          input = document.createElement("INPUT"),
          icon = document.createElement("I"),
          classNameLabel = entries[i][2].classname;

        label.className = 'fa-icon';

        input.setAttribute("type", "radio");


        if (currentScreen === "settings") {
          input.setAttribute("id", "fontawesome_icon_library");
          input.setAttribute("name", "redlum_contact_box[fontawesome_icon_library]");
        }else{
          input.setAttribute("id", "redlum_contact_box_font_awesome_icon");
          input.setAttribute("name", "redlum_contact_box_font_awesome_icon");
        }

        input.setAttribute("value", classNameLabel);
        icon.className = classNameLabel;

        label.appendChild(icon);
        label.appendChild(input);
        fieldset.appendChild(label);

      }

      for (let i = parseIndex; i <= parseLength; i++) {

        if( typeof entries[i] === 'undefined' || entries[i] === null ){
          loadMoreBtn.style.display = "none";
          break;
        }

        createIcon(i);

      }

      if (entries.length - parseLength < 50 ){

        for (let i = parseLength; i <= entries.length -1; i++) {
          createIcon(i);
        }

        loadMoreBtn.style.display = "none";
      }

      if (currentScreen == "settings"){

      document.querySelectorAll('#fontawesome_icon_library').forEach(function(item) {

        item.addEventListener("click", function(){
          document.getElementById("current_selected_icon").setAttribute("value", this.value);
        });

      });
      }

  }

  getIcons(parseIndex,parseLength);

  loadMoreBtn.addEventListener("click", function(e){
    e.preventDefault();

    parseIndex = parseLength + 50;
    parseLength = parseIndex + 50;

    getIcons(parseIndex,parseLength);

  });

  // Toggle State

  function toggleFields(status) {


    const faLibRowBtn = faLibRow.getElementsByTagName('button')[0];

    let uploadBtnValue = false,
      uploadInputValue = false,
      uploadTableValue = "opacity:1;",
      faFieldsValue = "opacity:0.4;",
      faColorPicker = true,
      faLoadmore = true;

    if (status === 'disable'){
      faColorPicker = false;
      faLoadmore = false;
      uploadBtnValue = true;
      uploadInputValue = true;
      uploadTableValue = "opacity:0.4;";
      faFieldsValue = "opacity:1;";
    }

    uploadBtn.disabled = uploadBtnValue;
    uploadInputField.disabled = uploadInputValue;
    uploadTableRow.setAttribute("style", uploadTableValue);

    faLibRowBtn.disabled = faColorPicker;
    iconColorRowBtn.disabled = faLoadmore;

    currentSelectedRow.setAttribute("style", faFieldsValue);
    faLibRow.setAttribute("style", faFieldsValue);
    iconColorRow.setAttribute("style", faFieldsValue);

  }

  // Check for Custom Icon usage

  if (customCheckbox.checked === false){
    toggleFields('disable');
  }else{
    toggleFields('enable');
  }

  // Click action

  customCheckbox.addEventListener("click", function(){
    if (customCheckbox.checked === false) {
      toggleFields('disable');
    }else{
      toggleFields('enable');
    }
  });



});
