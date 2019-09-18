import Vue from 'vue'
import AUTH from 'src/services/auth'
export default {
  saveSetting: false,
  template: {
    contents: {
      content: null,
      zoom: 100,
      setting: {
        units: null,
        actual: {
          height: null,
          width: null
        },
        page: {
          width: null,
          height: null
        },
        zoom: {
          width: null,
          height: null
        }
      },
      selectedTopMenu: null,
      activePageIndex: null,
      activeLayerIndex: null,
      activeObjectIndex: null,
      objectSettings: null,
      leftPane: {
        title: 'Pages',
        index: 2
      },
      overlay: {
        title: null,
        description: null,
        payload: null,
        payload_value: null
      },
      prompts: null,
      optionFlag: true
    },
    title: null,
    edit_flag: false,
    status: 0,
    category: null,
    purchased: null
  },
  getPageScreenSize(){
    let height = this.template.contents.setting.page.height
    let width = this.template.contents.setting.page.width
    let zoom = parseInt(this.template.contents.zoom)
    let size = {
      width: null,
      height: null
    }
    size.width = parseInt(parseInt(width) * (zoom / 100))
    size.height = parseInt(parseInt(height) * (zoom / 100))
    return size
  },
  addPrompts(title, message, btn){
    this.template.contents.prompts = {
      title: title,
      message: message,
      btn: btn // yes and no object
    }
  },
  addTemplate(template){
    this.template = template
  },
  addPage(){
    let newPage = {
      style: this.template.contents.content.style,
      title: 'Page',
      eye: true,
      layers: [],
      selected_layer: null,
      edit_flag: false,
      locked: false
    }
    this.template.contents.content.pages.push(newPage)
    let active = this.template.contents.content.pages.length - 1
    this.template.contents.activePageIndex = active
    this.template.contents.content.selected_page = active
    this.addLayer()
  },
  addLayer(){
    let layer = {
      title: 'Layer ',
      edit_flag: false,
      style: {
        background: 'transparent',
        height: this.template.contents.setting.page.height,
        width: this.template.contents.setting.page.width,
        top: 0,
        left: 0,
        borderRadius: 0,
        position: 'absolute'
      },
      eye: true,
      show: false,
      objects: [],
      selected_object: null,
      locked: false
    }
    let activePageIndex = this.template.contents.activePageIndex
    this.template.contents.content.pages[activePageIndex].layers.push(layer)
    let length = this.template.contents.content.pages[activePageIndex].layers - 1
    this.template.contents.content.pages[activePageIndex].selected_layer = length
    this.template.contents.activeLayerIndex = length
  },
  addObject(type, content){
    let halfWidth = this.template.contents.setting.page.width / 2
    let halfHeight = this.template.contents.setting.page.height / 2
    let object = {
      title: type,
      type: null,
      style: null,
      id: null,
      eye: true,
      content: null,
      edit_flag: false
    }
    if(type === 'Square'){
      object.style = {
        background: '#ffffff',
        height: 100,
        width: 100,
        top: halfHeight - 60,
        left: halfWidth - 60,
        borderRadius: 0,
        position: 'absolute',
        border: 'solid 1px #ddd',
        zIndex: 1
      }
      object.type = 'object'
      object.content = content
    }else if(type === 'Circle'){
      object.style = {
        background: '#ffffff',
        height: 100,
        width: 100,
        top: halfHeight - 60,
        left: halfWidth - 60,
        borderRadius: '50%',
        position: 'absolute',
        border: 'solid 1px #ddd',
        zIndex: 1
      }
      object.type = 'object'
      object.content = content
    }else if(type === 'text'){
      object.style = {
        background: 'transparent',
        height: 20,
        width: 100,
        top: halfHeight - 60,
        left: halfWidth - 60,
        borderRadius: 0,
        position: 'absolute',
        color: '#000000',
        fontSize: '12px',
        fontStyle: 'normal',
        textAlign: 'left',
        fontFamily: 'Arial',
        textDecoration: 'initial',
        fontWeight: 'normal',
        padding: '0px',
        zIndex: 1
      }
      object.type = 'text'
      object.content = content
    }else if(type === 'image'){
      object.style = {
        background: '#ffffff',
        height: 100,
        width: 100,
        top: halfHeight - 60,
        left: halfWidth - 60,
        borderRadius: 0,
        position: 'absolute',
        border: 'solid 1px #ddd',
        zIndex: 1
      }
      object.type = type
      object.content = content
    }
    let activePageIndex = this.template.contents.activePageIndex
    let activeLayerIndex = this.template.contents.activeLayerIndex
    this.template.contents.content.pages[activePageIndex].layers[activeLayerIndex].show = true
    this.template.contents.content.pages[activePageIndex].layers[activeLayerIndex].objects.push(object)
    let length = this.template.contents.content.pages[activePageIndex].layers[activeLayerIndex].objects - 1
    this.template.contents.content.pages[activePageIndex].layers[activeLayerIndex].selected_object = length
    this.template.contents.activeObjectIndex = length
  },
  zoomHandler(multiplier){
    let vue = new Vue()
    this.template.contents.zoom = multiplier
    if(this.template.contents.setting.page.width !== null && this.template.contents.setting.page.height !== null){
      this.template.contents.setting.zoom.width = parseInt(this.template.contents.setting.page.width * (multiplier / 100))
      this.template.contents.setting.zoom.height = parseInt(this.template.contents.setting.page.height * (multiplier / 100))
    }
  },
  save(){
    let vue = new Vue()
    let stringContents = JSON.stringify(this.template.contents)
    let parameter = {
      account_id: AUTH.user.userID,
      title: this.template.title,
      contents: '' + stringContents + '',
      status: this.template.status,
      purchased: this.template.purchased,
      category: this.template.category
    }
    if(this.saveSetting === false){
      vue.APIRequest('templates/create', parameter).then(response => {
        if(response.data > 0){
          let parameter = {
            condition: [{
              value: response.data,
              clause: '=',
              column: 'id'
            }]
          }
          this.retrieve(parameter)
        }
      })
    }else{
      parameter['id'] = this.template.id
      vue.APIRequest('templates/update', parameter).then(response => {
        if(response.data === true){
        }
      })
    }
  },
  retrieve(parameter){
    let vue = new Vue()
    $('#loading').css({'display': 'block'})
    vue.APIRequest('templates/retrieve', parameter).then(response => {
      $('#loading').css({'display': 'none'})
      if(response.data.length > 0){
        this.template = response.data[0]
        this.template.contents = JSON.parse(this.template.contents)
        this.saveSetting = true
      }
    })
  }
}
