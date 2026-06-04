# Application web d'orientation pour les nouveaux bacheliers
OrientaBac est une plateforme web qui aide les nouveaux bacheliers à choisir leur filière d'études supérieures grâce à un questionnaire d'orientation personnalisé et un système de recommandations intelligent.

## Data model summary

The platform manages three main actors with profile photos and the following key attributes:

| Class | Attribute | Description | Type | Size |
| --- | --- | --- | --- | --- |
| Admin | id_admin | Identifiant unique de l'administrateur (PK) | INT | 11 |
|  | nom | Nom de l'administrateur | VARCHAR | 100 |
|  | prenom | Prénom de l'administrateur | VARCHAR | 100 |
|  | email | Adresse email de l'administrateur | VARCHAR | 150 |
|  | password | Mot de passe chiffré | VARCHAR | 255 |
|  | photo | Chemin de la photo de profil de l'administrateur | VARCHAR | 255 |
| Responsable | id_responsable | Identifiant unique du responsable (PK) | INT | 11 |
|  | nom | Nom du responsable | VARCHAR | 100 |
|  | prenom | Prénom du responsable | VARCHAR | 100 |
|  | email | Adresse email du responsable | VARCHAR | 150 |
|  | password | Mot de passe chiffré | VARCHAR | 255 |
|  | photo | Chemin de la photo de profil du responsable | VARCHAR | 255 |
| User | id_user | Identifiant unique du bachelier (PK) | INT | 11 |
|  | nom | Nom du bachelier | VARCHAR | 100 |
|  | prenom | Prénom du bachelier | VARCHAR | 100 |
|  | email | Adresse email du bachelier | VARCHAR | 150 |
|  | password | Mot de passe chiffré | VARCHAR | 255 |
|  | id_serie | Référence à la série du bachelier (FK) | INT | 11 |
|  | photo | Chemin de la photo de profil du bachelier | VARCHAR | 255 |

Other entities include universities, campuses, filières, séries, matières, débouchés, actualités, témoignages, recommandations, années, abonnements and association tables.

