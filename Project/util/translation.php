<?php
/* utility function for translating db attributes in italian */
function translated($str) {
    switch(strtolower($str)) {
        // for users
        case 'lastname':     return "Cognome";
        case 'firstname':    return "Nome";
        // for products
        case 'name':         return "Nome";
        case 'price':        return "Prezzo";
        case 'imgpath':      return "Percorso immagine";
        case 'description':  return "Descrizione";
        case 'availability': return "Disponibilità";
        case 'npurchase':    return "N.acquisti"; break;
        // anything else, not yet implemented or that does not need transation
        default:             return ucfirst($str);
    }
}
