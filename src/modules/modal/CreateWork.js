import AUTH from 'src/services/auth'
import CONFIG from 'src/config.js'

export default {
  id: 'createWorkModal',
  size: 'modal-md',
  title: 'Add Work Experience',
  background: null,
  inputs: [{
    row: 'full',
    label: 'Name of the Company',
    variable: 'company_name',
    placeholder: 'Enter Company Name',
    value: null,
    required: true,
    id: 'companyName',
    type: 'input',
    inputType: 'text',
    validation: {
      size: 5,
      type: 'text'
    }
  }, {
    row: 'full',
    label: 'Position in the Company',
    variable: 'position',
    placeholder: 'Enter Position in the Company',
    value: null,
    required: true,
    id: 'position',
    type: 'input',
    inputType: 'text',
    validation: {
      size: 5,
      type: 'text'
    }
  }, {
    row: 'full',
    label: 'Location of the Company',
    variable: 'location',
    placeholder: 'Enter Location of the Company',
    value: null,
    required: true,
    id: 'location',
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
  }, {
    row: 'full',
    label: 'About your job description',
    variable: 'work_description',
    placeholder: 'Enter your job description',
    value: null,
    required: true,
    id: 'jobDescription',
    type: 'textarea',
    validation: {
      size: 5,
      type: 'text'
    },
    textAreaRows: 10
  }],
  route: 'works/create',
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
