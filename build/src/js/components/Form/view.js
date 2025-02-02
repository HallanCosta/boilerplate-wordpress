export default class FormView {
  // Dependencies
  formValidation = null;

  // Attributes
  form = null;
  fields = [];

  constructor(props) {
    console.log('> FormView', props);
    this.form = props.form;
    this.fields = props.fields;

    this.formValidation = props.formValidation;
  }

  cleanForm() {
    this.fields.map((field) => {
      if (
        field.validationType === this.formValidation.validationType.regex || 
        field.validationType === this.formValidation.validationType.length || 
        field.validationType === this.formValidation.validationType.selected
      ) {
        field.element.value = '';
      } else if (field.validationType === this.formValidation.validationType.checked) {
        field.element.value = false;
      }
    });
  }

  handleForm(onSubmitForm) {
    this.form.addEventListener('submit', async (e) => {
      e.preventDefault();

      const validations = this.fields.map((field) => {
        if (field.validationType === this.formValidation.validationType.regex) {
          return this.formValidation.isValidRegex(field);
        } else if (field.validationType === this.formValidation.validationType.length) {
          return this.formValidation.isValidLength(field);
        } else if (field.validationType === this.formValidation.validationType.checked) {
          return this.formValidation.isValidChecked(field);
        } else if (field.validationType === this.formValidation.validationType.selected) {
          return this.formValidation.isSelected(field);
        }
      });

      if (validations.includes(false)) {
        return false;
      }

      const formData = new FormData(this.form);
      onSubmitForm(formData);
    }); 
  }
}