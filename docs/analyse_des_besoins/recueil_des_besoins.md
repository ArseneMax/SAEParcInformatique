## I./ Chapitre 1 – Objectif et portée

## II./ Chapitre 2 – Terminologie employée / Glossaire

**SAé** (Situation d'Apprentissage et d'Évaluation) : Projet permettant aux étudiants de mettre en pratique des compétences techniques et théoriques acquises durant l'année.

**RPI (Raspberry Pi)** : Ordinateur monocarte utilisé pour héberger le serveur web du projet et exécuter l'application développée.

**Github** : Plateforme de gestion de versions utilisée pour héberger le code source du projet et permettre le suivi des modifications.

**Administrateur web** : Personne responsable de la gestion des utilisateurs inscrits,.

**Administrateur système** : Personne en charge de.

## III./ Chapitre 3 – Les cas d’utilisation

Le diagramme comprenant les acteurs principaux et leurs objectifs est dans le dossier images.

https://lucid.app/lucidchart/242ad7f1-f3cd-44f4-a3fa-189843b3b9f2/edit?viewport_loc=-689%2C-401%2C2875%2C1270%2C0_0&invitationId=inv_8fed3006-60b0-478b-baa6-75ba850befa1 

### Cas d'utilisation système : 



| Cas d'utilisation : | Créer un technicien |
| ----- | ----- |
| **Description** | L’administrateur souhaite ajouter un nouveau technicien dans la base de données. |
| **Portée** | Système |
| **Niveau** | Administrateur |
| **Acteur Principal** | Administrateur web |
| **Scénario nominal** | 1\. L’administrateur accède à l’interface de gestion des techniciens. 2\. Il sélectionne « Ajouter un technicien ». 3\. Il saisit les informations du technicien. 4\. Il valide. 5\. Le système enregistre le technicien. 6\. Une confirmation est affichée. |
| **Scénarios alternatifs** |  |
| **Scénario exceptionnel** | 1\. Le login existe déjà → Message indiquant que le compte existe. 2\. Données manquantes ou incorrectes → Erreur de validation du formulaire. |
| **Pré-condition** | L’administrateur est connecté. |
| **Post-conditions** | Le technicien est créé et peut se connecter. |

| Cas d'utilisation : | Créer une information |
| ----- | ----- |
| **Description** | L’administrateur crée une information utilisable par les techniciens (OS, constructeur). |
| **Portée** | Système |
| **Niveau** | Administrateur |
| **Acteur Principal** | Administrateur web |
| **Scénario nominal** | 1\. L’administrateur accède à la gestion des informations. 2\. Il choisit le type d’information à ajouter. 3\. Il saisit la valeur. 4\. Il valide. 5\. Le système enregistre l’information. 6\. Une confirmation est affichée. |
| **Scénarios alternatifs** |  |
| **Scénario exceptionnel** | 1\. L’information existe déjà → Message d’erreur (doublon). |
| **Pré-condition** | L’administrateur est connecté. |
| **Post-conditions** | L’information est disponible dans les formulaires des techniciens. |

| Cas d'utilisation : | Consulter le parc informatique |
| ----- | ----- |
| **Description** | Le technicien consulte la liste complète des machines. |
| **Portée** | Système |
| **Niveau** | Utilisateur |
| **Acteur Principal** | Technicien |
| **Scénario nominal** | 1\. Le technicien se connecte. 2\. Il accède à l’inventaire 3\. Il choisit la catégorie qu’il veut regarder 4\. Le système affiche la liste des machines. |
| **Scénarios alternatifs** |  |
| **Scénario exceptionnel** |  |
| **Pré-condition** | Le technicien est connecté. |

| Cas d'utilisation : | Modifier une machine |
| ----- | ----- |
| **Description** | Le technicien modifie une machine existante du parc. |
| **Portée** | Système |
| **Niveau** | Utilisateur |
| **Acteur Principal** | Technicien |
| **Scénario nominal** | 1\. Le technicien consulte le parc informatique. 2\. Il sélectionne une machine. 3\. Il modifie une ou plusieurs informations. 4\. Il valide. 5\. Le système enregistre les changements. 6\. Une confirmation est affichée. |
| **Scénarios alternatifs** |  |
| **Scénario exceptionnel** |  |
| **Pré-condition** | Le technicien est connecté, une machine existe. |
| **Post-conditions** | Les informations sont mises à jour. |

| Cas d'utilisation : | Ajouter une machine |
| ----- | ----- |
| **Description** | Le technicien ajoute une nouvelle machine à l’inventaire via un formulaire. |
| **Portée** | Système |
| **Niveau** | Utilisateur |
| **Acteur Principal** | Technicien |
| **Scénario nominal** | 1\. Le technicien ouvre le formulaire d’ajout. 2\. Il saisit les informations de la machine. 3\. Il sélectionne les informations réutilisables. 4\. Il valide. 5\. Le système ajoute la machine au parc. 6\. Une confirmation est affichée. |
| **Scénarios alternatifs** |  |
| **Scénario exceptionnel** | 1\. Formulaire incomplet → Enregistrement refusé. 2\. Numéro de série déjà existant → Message d’erreur. |
| **Pré-condition** | Le technicien est connecté. |
| **Post-conditions** | La machine est enregistrée dans l’inventaire. |

| Cas d'utilisation : | Consulter les statistiques |
| ----- | ----- |
| **Description** | consulter les statistiques du parc |
| **Portée** | Système |
| **Niveau** | Utilisateur |
| **Acteur Principal** | Utilisateurs |
| **Scénario nominal** | 1\. Se connecter 2\. Aller dans la section statistiques |
| **Scénarios alternatifs** |  |
| **Scénario exceptionnel** |  |
| **Pré-condition** | Être connecté |

| Cas d'utilisation : | Créer compte utilisateur                                                                                                                                                                   |
|---------------------|-------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------|
| **Description**         | Un visiteur veut créer un compte utilisateur                                                                                                            |
|**Portée**              | Système ⬛                                                                                                                                                                                       |
| **Niveau**              | Utlisateur 🌊                                                                                                                                                                                   |
| **Acteur Principale**   | Visiteur                                                                                                                                                                                        |                                                                                |
|**Scénario nominal**    | 1. Le visiteur se rends sur le formulaire d'inscription <br/> 2. Le visiteur rentre ses informations <br/> 3. Une confirmation est affiché au visiteur <br/> |
| **Scénario alternatifs** |                                                                                                                                                                                                 |
| **Scénario exceptionnel** | 1. Le login existe déja <br/>  &nbsp; &nbsp; &nbsp; &nbsp; a. Le visiteur se rends sur le formulaire d'inscription <br/> &nbsp; &nbsp; &nbsp; &nbsp; b. Le visiteur rentre ses informations <br/>                             &nbsp; &nbsp; &nbsp; &nbsp; c. Le visiteur valide le captcha <br/>  &nbsp; &nbsp; &nbsp; &nbsp; d. Renvoie une erreur lui indiquant que le login est déja pris <br/>2. Le login ne possède pas le                             nombre de caractères requis <br/>  &nbsp; &nbsp; &nbsp; &nbsp; a. Le visiteur se rends sur le formulaire d'inscription <br/> &nbsp; &nbsp; &nbsp; &nbsp; b. Le visiteur rentre ses informations                               <br/> &nbsp; &nbsp; &nbsp; &nbsp; c. Le visiteur valide le captcha <br/>  &nbsp; &nbsp; &nbsp; &nbsp; d.Renvoie une erreur lui indiquant que le login ne possède pas le nombre nécessaire de                                   caractères                                                                                                                                                                                   |
| **Post-Conditions**     | Un compte utilisateur a été crée.                                                                                                                                                               |



| Cas d'utilisation : | Se connecter                                                                                                                                                                                         |
|--------------------|------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------|
| **Description**        | Un visiteur veut se connecter a son compte utilisateur                                                                                                                                               |
| **Portée**            | Système ⬛                                                                                                                                                                                            |
| **Niveau**             | Utlisateur 🌊                                                                                                                                                                                        |
| **Acteur Principale**  | Visiteur                                                                                                                                                                                             |                                                                                |
| **Scénario nominal**   | 1. Le visiteur se rends sur le formulaire de connexion <br/> 2. Le visiteur rentre ses informations <br/> 3. Le visiteur valide <br/> 4. Une confirmation de connexion est affiché au visiteur <br/> |
| **Scénario alternatifs**|  1. L'utilisateur se connecte grace a un cookie                                                                                                                                                      |
| **Scénario exceptionnel**|1. L'utilisateur se trompe de mot de passe <br/>  &nbsp; &nbsp; &nbsp; &nbsp; a. Le visiteur se rends sur le formulaire de connexion <br/>  &nbsp; &nbsp; &nbsp; &nbsp; b. Le visiteur rentre ses                             informations <br/> &nbsp; &nbsp; &nbsp; &nbsp; c. Le visiteur valide <br/>  &nbsp; &nbsp; &nbsp; &nbsp; d.  Renvoie une erreur lui indiquant que le mot de passe ne correspond pas  <br/> 2. Le                               login n'existe pas <br/>  &nbsp; &nbsp; &nbsp; &nbsp; a. Le visiteur se rends sur le formulaire de connexion <br/>  &nbsp; &nbsp; &nbsp; &nbsp; b. Le visiteur rentre ses informations <br/> &nbsp;                           &nbsp; &nbsp; &nbsp; c. Le visiteur valide <br/>  &nbsp; &nbsp; &nbsp; &nbsp; d. Renvoie une erreur lui indiquant que le login n'existe pas                                                         |
| **Pré-condition**      | Il existe un compte utilisateur correspondant aux informations du visiteur.                                                                                                                          |
| **Post-Conditions**    | Le visiteur est désormais connectés en tant qu'utilisateur.                                                                                                                                          |


|Cas d'utilisation :| Se déconnecter |
|--------------------|-----------------------|
|**Description**| Un utilisateur veut se déconnecter de son compte|
|**Portée**| Système ⬛ |
|**Niveau**| Utilisateur 🌊|
|**Acteur Principale**| utilisateur |
|**Scénario Nominal**|1. L'utilisateur va sur son profil <br/> 2. Appuie sur le bouton pour se déconnecter|
|**Scénario alternatif**||
|**Scénario Exceptionnel**||
|**Pré-condition**|Possède un compte|


|Cas d'utilisation :| Verifier la validité du contenu du formulaire de d'inscription |
|--------------------|-----------------------|
|**Description**| Un utilisateur veut vérifier que les informations d'inscription  qu'il a entré dans le formulaire sont correctes |
|**Portée**| Sous-partie 🔩 |
|**Niveau**| Utilisateur 🌊 |
|**Acteur Principale**| utilisateur |
|**Scénario Nominal**|1. L'utilisateur accède au formulaire d'inscription du site</br>2. L'utilisateur entre ses informations personelles pour se connecter </br>3. L'utilisateur clique sur le bouton de vérification du formulaire</br>|
|**Scénario alternatif**||
|**Scénario Exceptionnel**||
|**Pré-condition**||

|Cas d'utilisation :| Verifier la validité du contenu du formulaire de connexion |
|--------------------|-----------------------|
|**Description**| Un utilisateur veut vérifier que les informations qu'il a entré dans le formulaire sont correctes |
|**Portée**| Sous-partie 🔩 |
|**Niveau**| Utilisateur 🌊 |
|**Acteur Principale**| utilisateur |
|**Scénario Nominal**|1. L'utilisateur accède au formulaire d'inscription du site</br>2. L'utilisateur entre ses informations de connexions </br>2. L'utilisateur clique sur le bouton de vérification du formulaire</br>|
|**Scénario alternatif**||
|**Scénario Exceptionnel**||
|**Pré-condition**||

## IV./ Chapitre 4 – La technologie employée

Il existe des exigences techniques pour ce projet tel que :
- L'utilisation d'un serveur ***Apache***
- L'utilisation d'un serveur ***SQL***
- Héberger les serveurs sur le ***RaspberryPi*** mis a disposition par l'IUT
- Développez le site et ses modules en ***PHP***

## V./ Chapitre 5 – Autres exigences 
