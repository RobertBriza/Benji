import "/src/styles/main.css"
import {Application, Controller} from '@hotwired/stimulus'
import "@hotwired/turbo"
import naja from "naja"
import {SpinnerExtension} from './spinner'


naja.uiHandler.selector = ':not(.noajax)'
naja.initialize()
naja.registerExtension(new SpinnerExtension('.mainContent'))
naja.addEventListener('error', (event) => {
  const error = event.detail.error

  if (typeof error.status === 'undefined') {
    console.log(`Error: ${error}`)
    return
  }

  console.log(`Error ${error.response.status}: ${error.response.statusText} at ${error.response.url}`)
})

window.naja = naja;

const LibStimulus = new Application(document.documentElement)

LibStimulus.start()

LibStimulus.register('body', class extends Controller {
  connect() {

  }
})

