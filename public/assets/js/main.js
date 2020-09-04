$(document).ready( function () {
    $('#arret_list').DataTable({
        "pageLength": 10,
        language: {
            processing:     "Traitement en cours...",
            search:         "Rechercher&nbsp;:",
            lengthMenu:     "Afficher _MENU_ &eacute;l&eacute;ments",
            info:           "Affichage de _START_ &agrave; _END_ sur _TOTAL_ lignes",
            infoEmpty:      "Affichage de 0 &agrave; 0 sur 0 lignes",
            infoFiltered:   "(filtr&eacute; de _MAX_ lignes au total)",
            infoPostFix:    "",
            loadingRecords: "Chargement en cours...",
            zeroRecords:    "Aucun &eacute;l&eacute;ment &agrave; afficher",
            emptyTable:     "Aucune donnée disponible",
            paginate: {
                first:      "Premier",
                previous:   "<i class='fas fa-caret-left'></i>",
                next:       "<i class='fas fa-caret-right'></i>",
                last:       "Dernier"
            },
            aria: {
                sortAscending:  ": activer pour trier la colonne par ordre croissant",
                sortDescending: ": activer pour trier la colonne par ordre décroissant"
            }
        }
    });

    $R('.redactor',{
        minHeight  : '350px',
        maxHeight: '450px',
        removeEmpty : [ 'strong' , 'em' , 'span' , 'p' ],
        lang: 'fr',
        plugins: ['imagemanager','filemanager','fontsize','fontcolor','alignment'],
        fileUpload : 'backend/uploadRedactor?_token=' + $('meta[name="csrf-token"]').attr('content'),
        imageUpload: 'backend/uploadRedactor?_token=' + $('meta[name="csrf-token"]').attr('content'),
        imageManagerJson: 'backend/imageJson?_token=' + $('meta[name="csrf-token"]').attr('content'),
        fileManagerJson: 'backend/fileJson?_token=' + $('meta[name="csrf-token"]').attr('content'),
        imageResizable: true,
        imagePosition: true,
        formatting: ['h1', 'h2','h3','p', 'blockquote']
    });

    $.fn.datepicker.dates['fr'] = {
        days: ["dimanche", "lundi", "mardi", "mercredi", "jeudi", "vendredi", "samedi"],
        daysShort: ["dim.", "lun.", "mar.", "mer.", "jeu.", "ven.", "sam."],
        daysMin: ["d", "l", "ma", "me", "j", "v", "s"],
        months: ["janvier", "février", "mars", "avril", "mai", "juin", "juillet", "août", "septembre", "octobre", "novembre", "décembre"],
        monthsShort: ["janv.", "févr.", "mars", "avril", "mai", "juin", "juil.", "août", "sept.", "oct.", "nov.", "déc."],
        today: "Aujourd'hui",
        monthsTitle: "Mois",
        clear: "Effacer",
        weekStart: 1,
        format: "dd/mm/yyyy"
    };

    let fr = {
        firstDayOfWeek: 1,
        weekdays: {
            shorthand: ["dim", "lun", "mar", "mer", "jeu", "ven", "sam"],
            longhand: [
                "dimanche",
                "lundi",
                "mardi",
                "mercredi",
                "jeudi",
                "vendredi",
                "samedi",
            ],
        },
        months: {
            shorthand: [
                "janv",
                "févr",
                "mars",
                "avr",
                "mai",
                "juin",
                "juil",
                "août",
                "sept",
                "oct",
                "nov",
                "déc",
            ],
            longhand: [
                "janvier",
                "février",
                "mars",
                "avril",
                "mai",
                "juin",
                "juillet",
                "août",
                "septembre",
                "octobre",
                "novembre",
                "décembre",
            ],
        },
        ordinal: function (nth) {
            if (nth > 1)
                return "";
            return "er";
        },
        rangeSeparator: " au ",
        weekAbbreviation: "Sem",
        scrollTitle: "Défiler pour augmenter la valeur",
        toggleTitle: "Cliquer pour basculer",
        time_24hr: true,
    };

/*    if ($('.datePicker').length) {
        $(".datePicker").flatpickr({
            altInput: true,
            altFormat: "j F Y",
            dateFormat: "Y-m-d",
            locale: fr
        });
    }*/

});
