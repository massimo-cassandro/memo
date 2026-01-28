// file di configurazione per `create-favicons`.
// I valori indicati sono quelli di default.
// Per avviare la generazione delle favicon digitare `npx create-favicons` dalla dir corrente.

const params = [{

  // tutti i percorsi sono relativi alla dir di lavoro

  // immagine sorgente SVG o PNG 512x512
  src_img: 'favicon-verde-src.svg',

  // sorgente opzionale per immagini piccole (32px)
  small_src_img: 'favicon-verde-small-src.svg',

  // directory output (percorso relativo alla dir di lavoro)
  // se la dir non esiste, viene creata
  output_dir: './output',

  // chiavi aggiuntive per webmanifest, normalmente non necessarie per il browser
  // vedi https://developer.mozilla.org/en-US/docs/Web/Manifest
  // esempio:
  // webmanifest_extra: {
  //   name: "my Application",
  //   short_name: "my app",
  //   background_color: "#ffffff",
  //   theme_color: "#ffffff",
  //   display: "fullscreen"
  // }
  webmanifest_extra: {
    // 'short_name': 'Calibre-reader',
    // 'name': 'Calibre-reader',
    // 'start_url': '.',
    // 'display': 'standalone',
    // 'theme_color': '#1D71B8',
    // 'background_color': '#ffffff'
  },


  // SNIPPET
  //****************************************************************************

  // nome del file snippet, compresa l'estensione
  // se null, lo snippet non viene generato
  snippet_name: 'favicon.incl.ejs',

  // path (relativo a questo file) in cui salvare lo snippet
  // se null, viene utilizzato lo stesso percorso indicato in `output_dir`
  // se la dir non esiste, viene creata
  snippet_path: null,

  // linguaggio da utilizzare per la sintassi dello snippet html
  // html o pug
  snippet_language: 'ejs',

  // template per la costruzione dello snippet.
  // si tratta di una stringa (anche su più righe) in cui deve essere presente
  // '%_link_tags_%', che verrà sostituito con i tag links dei vari file
  snippet_template: '%_link_tags_%',

  // template per la costruzione di ogni singolo attributo `href` dei tag link.
  // deve contenere la stringa '%_file_name_%', che conterrà il nome del file,
  // e la stringa '%_cache_buster_%' (se attivata)', che conterrà `?_=xxxx`, dove
  // 'xxxx' rappresenta il timestamp generato per annullare la cache.
  // Va scritto tenendo conto del linguaggio utilizzato.
  href_template: './%_file_name_%%_cache_buster_%',

  // se true aggiunge allo snippet una query string per ovviare ad eventuali
  // problemi di caching del browser
  add_cache_buster: false

  //****************************************************************************


}];

export default params;
