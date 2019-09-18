import AUTH from 'src/services/auth'
import CONFIG from 'src/config.js'

export default {
  id: 'createEducationModal',
  size: 'modal-md',
  title: 'Add Education',
  background: null,
  inputs: [{
    row: 'full',
    label: 'School',
    variable: 'school',
    placeholder: 'Enter Your School',
    value: null,
    required: true,
    id: 'school',
    type: 'input',
    inputType: 'text',
    validation: {
      size: 2,
      type: 'text'
    }
  }, {
    row: 'full',
    label: 'Degree',
    variable: 'degree',
    placeholder: 'Enter Your Degree',
    value: null,
    required: true,
    id: 'degree',
    type: 'input',
    inputType: 'text',
    validation: {
      size: 3,
      type: 'text'
    }
  }, {
    row: 'full',
    label: 'Field of Study',
    variable: 'field_of_study',
    placeholder: 'Enter Your Field of Study',
    value: null,
    required: true,
    id: 'fieldOfStudy',
    type: 'input',
    inputType: 'text',
    validation: {
      size: 5,
      type: 'text'
    }
  }, {
    row: 'half',
    label: 'Year Started',
    variable: 'year_started',
    value: null,
    required: true,
    id: 'yearStarted',
    type: 'select_decrement',
    options: {
      start: CONFIG.years.current + 1,
      max: CONFIG.years.max,
      label: ''
    }
  }, {
    row: 'half',
    label: 'Month Started',
    variable: 'month_started',
    value: null,
    required: true,
    id: 'monthStarted',
    type: 'select_specified',
    options: [
      {value: 'January', label: 'January'},
      {value: 'February', label: 'February'},
      {value: 'March', label: 'March'},
      {value: 'April', label: 'April'},
      {value: 'May', label: 'May'},
      {value: 'June', label: 'June'},
      {value: 'July', label: 'July'},
      {value: 'August', label: 'August'},
      {value: 'September', label: 'September'},
      {value: 'October', label: 'October'},
      {value: 'November', label: 'November'},
      {value: 'December', label: 'December'}
    ]
  }, {
    row: 'half',
    label: 'Year Ended',
    variable: 'year_ended',
    value: null,
    required: true,
    id: 'yearEnded',
    type: 'select_increment',
    options: {
      start: CONFIG.years.current - 1,
      max: CONFIG.years.max,
      label: ''
    }
  }, {
    row: 'half',
    label: 'Month Ended',
    variable: 'month_ended',
    value: null,
    required: true,
    id: 'monthEnded',
    type: 'select_specified',
    options: [
      {value: 'January', label: 'January'},
      {value: 'February', label: 'February'},
      {value: 'March', label: 'March'},
      {value: 'April', label: 'April'},
      {value: 'May', label: 'May'},
      {value: 'June', label: 'June'},
      {value: 'July', label: 'July'},
      {value: 'August', label: 'August'},
      {value: 'September', label: 'September'},
      {value: 'October', label: 'October'},
      {value: 'November', label: 'November'},
      {value: 'December', label: 'December'}
    ]
  }],
  route: 'educations/create',
  button: {
    left: 'Cancel',
    right: 'Submit'
  },
  sort: {
    column: 'created_at',
    value: 'desc'
  },
  params: [{
    variable: 'account_id',
    value: AUTH.user.userID
  }]
}
