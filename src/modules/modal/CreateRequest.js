import CONFIG from '../../config.js'
export default {
  id: 'createRequestModal',
  size: 'modal-md',
  title: 'Add Request',
  background: null,
  inputs: [{
    row: 'full',
    label: 'I want to borrow the amount of',
    variable: 'amount',
    placeholder: 'Enter amount',
    value: null,
    required: true,
    id: 'amount',
    type: 'input',
    inputType: 'number',
    validation: {
      size: CONFIG.MINIMUM_INVESTMENT,
      type: 'number'
    }
  }, {
    row: 'full',
    label: 'I will pay with an interest rate of',
    variable: 'interest',
    placeholder: null,
    value: 2,
    required: true,
    id: 'interest',
    type: 'select_increment',
    options: {
      max: 30,
      label: '% per month'
    }
  }, {
    row: 'full',
    label: 'I will pay with in',
    variable: 'months_payable',
    placeholder: null,
    value: 1,
    required: true,
    id: 'monthPayable',
    type: 'select_increment',
    options: {
      max: 12,
      label: ' Month(s)'
    }
  }, {
    row: 'full',
    label: 'I need this on',
    variable: 'needed_on',
    placeholder: 'Select Date',
    value: null,
    required: true,
    id: 'neededOn',
    type: 'input',
    inputType: 'date',
    validation: {
      size: null,
      type: 'date'
    }
  }, {
    row: 'full',
    label: 'I will pay',
    variable: 'billing_per_month',
    placeholder: null,
    value: 0,
    required: true,
    id: 'billingPerMonth',
    type: 'select_specified',
    options: [
      {value: 0, label: 'Every end of the month'},
      {value: 1, label: 'Twice a month'},
      {value: 2, label: 'Every end of the week'}
    ]
  }, {
    row: 'full',
    label: 'The reason I borrow is',
    variable: 'reason',
    placeholder: 'Enter reason here',
    value: null,
    required: true,
    id: 'reason',
    type: 'textarea',
    validation: {
      size: 5,
      type: 'text'
    },
    textAreaRows: 10
  }],
  route: 'requests/create',
  button: {
    left: 'Cancel',
    right: 'Submit'
  },
  sort: {
    column: 'created_at',
    value: 'desc'
  },
  params: [{
    variable: 'status',
    value: 0
  }]
}
