import app_template from './app-template.html';
import { params } from './params';
import { setListeners } from './listeners';
import logo from '../favicons/favicon-verde-src.svg';

(async () => {
  document.getElementById('root').innerHTML = app_template.replace('{{logo}}', logo);

  params.result_wrapper  = document.querySelector('.result-wrapper');
  params.search_form     = document.getElementById('search-form');
  params.search_fset     = params.search_form.querySelector('.search-fset');
  params.search_input    = params.search_fset.querySelector('.search-input');
  params.spinner_wrapper = document.querySelector('.spinner-wrapper');

  setListeners();

})();
