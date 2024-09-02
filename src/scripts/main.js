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

naja.snippetHandler.addEventListener('afterUpdate', (event) => {

  const {snippet} = event.detail

  function fadeOutAndHide(element) {
    element.querySelectorAll('div').forEach(div => {
      if (div.classList.contains('bg-slate-700')) {
        return
      }

      div.classList.add('bg-slate-700')

      setTimeout(() => {

        div.classList.add('animate-fade')

        function handleAnimationEnd() {
          div.remove()
          div.removeEventListener('animationend', handleAnimationEnd)
        }

        // Add an event listener for when the animation ends
        div.addEventListener('animationend', handleAnimationEnd, {once: true})
      }, 3000)
    })
  }

  if (snippet.id === 'snippet--flashes') {
    fadeOutAndHide(snippet)
  }
})

window.naja = naja;

const LibStimulus = new Application(document.documentElement)

LibStimulus.start()

LibStimulus.register('body', class extends Controller {
  connect() {

  }
})

