export default {
  style (style, zoom, setting, flag) {
    // get height
    // get width
    // get position top / left
    // get border radius
    // get border
    // get the ratio of pageSize
    // return the style
    style.top = parseInt(style.top)
    style.left = parseInt(style.left)
    style.width = parseInt(style.width)
    style.height = parseInt(style.height)
    let tempSize = parseInt(20 * (zoom / 100))
    let size = tempSize % 2 ? tempSize : tempSize - 1
    let position = parseInt(size / 2)
    let tempStyle = {}
    let modifiedArray = ['height', 'width', 'top', 'left', 'background']
    zoom = parseInt(zoom)
    if(flag === 0){
      tempStyle['height'] = parseInt(style.height * (zoom / 100)) + setting.units
      tempStyle['width'] = parseInt(style.width * (zoom / 100)) + setting.units
      tempStyle['top'] = parseInt(style.top * (zoom / 100)) + setting.units
      tempStyle['left'] = parseInt(style.left * (zoom / 100)) + setting.units
      tempStyle['background'] = style.background
    }else if(flag === 1){
      let top = (parseInt(style.top * (zoom / 100)))
      let left = (parseInt(style.left * (zoom / 100)))
      tempStyle['height'] = (parseInt(style.height * (zoom / 100)) + size) + setting.units
      tempStyle['width'] = (parseInt(style.width * (zoom / 100)) + size) + setting.units
      tempStyle['top'] = top + setting.units
      tempStyle['left'] = left + setting.units
      tempStyle['background'] = 'transparent'
    }else if(flag === 2){
      tempStyle['height'] = parseInt(style.height * (zoom / 100)) + setting.units
      tempStyle['width'] = parseInt(style.width * (zoom / 100)) + setting.units
      tempStyle['top'] = position + setting.units
      tempStyle['left'] = position + setting.units
      tempStyle['background'] = style.background
      tempStyle['zIndex'] = parseInt(style.zIndex) + 1
    }
    // tempStyle['borderRadius'] = parseInt(parseInt(style.borderRadius) * (zoom / 100)) + setting.units
    let objectAttributes = Object.keys(style)
    objectAttributes.map(item => {
      if(modifiedArray.indexOf(item) < 0){
        tempStyle[item] = style[item]
      }
    })
    return tempStyle
  },
  resize(zoom, setting, style){
    let tempStyle = {}
    tempStyle['width'] = parseInt(10 * (zoom / 100)) + setting.units
    tempStyle['height'] = parseInt(10 * (zoom / 100)) + setting.units
    let objectAttributes = Object.keys(style)
    objectAttributes.map(item => {
      tempStyle[item] = style[item]
    })
    return tempStyle
  },
  resizeEdge(zoom, setting, object, item){
    let tempStyle = {}
    let width = parseInt(object.width * (zoom / 100))
    let height = parseInt(object.height * (zoom / 100))
    let size = parseInt(10 * (zoom / 100))
    switch(item.section){
      case 'left':
        tempStyle['top'] = size + setting.units
        tempStyle['left'] = 0 + setting.units
        tempStyle['width'] = size + setting.units
        tempStyle['height'] = height + setting.units
        break
      case 'top':
        tempStyle['top'] = 0 + setting.units
        tempStyle['left'] = size + setting.units
        tempStyle['width'] = width + setting.units
        tempStyle['height'] = size + setting.units
        break
      case 'right':
        tempStyle['right'] = 0 + setting.units
        tempStyle['top'] = size + setting.units
        tempStyle['width'] = size + setting.units
        tempStyle['height'] = height + setting.units
        break
      case 'bottom':
        tempStyle['bottom'] = 0 + setting.units
        tempStyle['left'] = size + setting.units
        tempStyle['width'] = width + setting.units
        tempStyle['height'] = size + setting.units
        break
    }
    return tempStyle
  }
}
