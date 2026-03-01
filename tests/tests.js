/**
 * Tests pour L1_Association_2013 (PHP natif)
 * Validation des fonctions de validation
 * Execution: node tests.js
 */

const TESTS_RESULTS = { passed: 0, failed: 0 };

function assert(description, condition) {
    if (condition) {
        console.log(`[PASS] ${description}`);
        TESTS_RESULTS.passed++;
    } else {
        console.log(`[FAIL] ${description}`);
        TESTS_RESULTS.failed++;
    }
}

/**
 * Valide une adresse email.
 * @param {string} email Email a valider.
 * @returns {boolean} True si valide.
 */
function validerEmail(email) {
    const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return regex.test(email);
}

/**
 * Valide un code postal francais.
 * @param {string} codePostal Code postal.
 * @returns {boolean} True si valide.
 */
function validerCodePostal(codePostal) {
    return /^[0-9]{5}$/.test(codePostal);
}

/**
 * Valide une date au format JJ/MM/AAAA.
 * @param {string} date Date a valider.
 * @returns {boolean} True si valide.
 */
function validerDate(date) {
    const regex = /^(\d{2})\/(\d{2})\/(\d{4})$/;
    const match = date.match(regex);
    if (!match) return false;

    const jour = parseInt(match[1]);
    const mois = parseInt(match[2]);
    const annee = parseInt(match[3]);

    if (mois < 1 || mois > 12) return false;
    if (jour < 1 || jour > 31) return false;
    if (annee < 1900 || annee > 2100) return false;

    return true;
}

/**
 * Valide un identifiant.
 * @param {string} identifiant Identifiant a valider.
 * @returns {boolean} True si valide (alphanumerique, 3-20 caracteres).
 */
function validerIdentifiant(identifiant) {
    return /^[a-zA-Z0-9]{3,20}$/.test(identifiant);
}

/**
 * Calcule l'anciennete en jours.
 * @param {Date} dateInscription Date d'inscription.
 * @returns {number} Nombre de jours.
 */
function calculerAnciennete(dateInscription) {
    const maintenant = new Date();
    const difference = maintenant - dateInscription;
    return Math.floor(difference / (1000 * 60 * 60 * 24));
}

// ==================== TESTS ====================

console.log("=== Tests L1-Association ===\n");

// Tests email
assert("Email valide simple", validerEmail("test@example.com"));
assert("Email valide avec sous-domaine", validerEmail("user@mail.example.com"));
assert("Email invalide sans @", !validerEmail("testexample.com"));
assert("Email invalide sans domaine", !validerEmail("test@"));

// Tests code postal
assert("Code postal valide", validerCodePostal("75001"));
assert("Code postal invalide trop court", !validerCodePostal("7500"));
assert("Code postal invalide avec lettres", !validerCodePostal("75AB1"));

// Tests date
assert("Date valide", validerDate("15/06/1990"));
assert("Date invalide format", !validerDate("1990-06-15"));
assert("Date invalide mois", !validerDate("15/13/1990"));
assert("Date invalide jour", !validerDate("32/06/1990"));

// Tests identifiant
assert("Identifiant valide", validerIdentifiant("user123"));
assert("Identifiant trop court", !validerIdentifiant("ab"));
assert("Identifiant avec caracteres speciaux", !validerIdentifiant("user@123"));

// Tests anciennete
assert("Anciennete positive", (() => {
    const datePassee = new Date();
    datePassee.setDate(datePassee.getDate() - 10);
    return calculerAnciennete(datePassee) >= 10;
})());

// ==================== RESUME ====================

console.log("\n=== Resume ===");
console.log(`Tests passes: ${TESTS_RESULTS.passed}`);
console.log(`Tests echoues: ${TESTS_RESULTS.failed}`);

if (TESTS_RESULTS.failed > 0) process.exit(1);
