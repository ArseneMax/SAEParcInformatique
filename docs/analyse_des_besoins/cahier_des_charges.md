   
# **Cahier des charges**

**I./ Introduction**

### **1.Contexte**

Le projet s'inscrit dans le cadre de la seconde année de BUT informatique à l'IUT de Vélizy, durant les semestres 3 et 4 de l'année 2025-2026. Il s'agit d'un projet transversal qui mobilise de nombreuses ressources du semestre, couvrant des domaines variés tels que le développement web (R301), le développement efficace (R302), l'analyse (R303), la qualité de développement (R304), la programmation système et l'architecture réseau (R305/R306), ainsi que d'autres aspects comme le SQL (R307), les probabilités (R308), la cryptographie (R309), le management des SI (R310/R311) et la communication professionnelle (R313).

La plateforme que nous devons développer sera hébergée sur un serveur Raspberry Pi 4 (RPI4) fourni par l'IUT. Ce choix technique nous projette dans un monde professionnel car nous devrons nous-mêmes procéder à l'installation et à la configuration complète de l'environnement, incluant le système d'exploitation, le serveur web et l'ensemble des applications nécessaire pour notre plateforme.

### **2.Objectifs**

Ce document a pour vocation première de définir avec précision le projet et l'ensemble de ses fonctionnalités. Il servira de référence tout au long du développement, permettant d'assurer une communication claire entre les différents intervenants, qu'il s'agisse des professeurs ou des futurs utilisateurs. Dans un contexte de travail en équipe de cinq étudiants, selon nous, il est essentiel d'avoir une base documentaire solide qui guidera nos efforts de développement et servira de support pour l'évaluation finale du projet.

Nous développerons de notre mieux pour avoir une plateforme web performante et sécurisée, qui offrira une plateforme de gestion de parc informatique accessible via une interface web. Une attention particulière sera portée à la documentation du projet, qui devra respecter les bonnes pratiques de programmation et de gestion de projet.

### **3.Structure**

Ce cahier des charges est structuré de manière logique pour couvrir tous les aspects du projet. Il commence par une introduction, qui présente le contexte et les objectifs, suivie d’une description technique détaillée, incluant un énoncé clair des objectifs du projet et des spécifications du serveur. La section des pré-requis du projet énumère les technologies (PHP, SQL, etc.) et les ressources (comme le Raspberry Pi 4\) nécessaires. Nous y décrivons également les priorités de développement établies pour répondre efficacement aux attentes du client. Enfin, les fonctionnalités de la plateforme sont exposées en détail, avec une lecture approfondie du cahier des charges et une expression des exigences fonctionnelles et techniques.

### **4.Documents**

Documents référencés : 0 pour l'instant

**II./ Enoncé** 

Le projet a pour ambition la gestion d’un parc informatique robuste capable d'accueillir plusieurs utilisateurs, répondant ainsi aux besoins spécifiques du client. Cette plateforme doit non seulement gérer efficacement les informations liées aux utilisateurs mais aussi assurer une gestion fiable et performante du parc informatique à travers son inventaire.

L'interface utilisateur constitue un aspect crucial du projet. Le site web doit être intuitif et facilement accessible, permettant une prise en main rapide par les différents utilisateurs. Pour faciliter cette appropriation, la plateforme doit être accompagnée d'un texte explicatif détaillé ainsi que d'une vidéo de présentation mettant en valeur ses fonctionnalités.

Au cœur de l'application se trouve un inventaire du parc informatique qui sera défini ultérieurement selon les besoins du client. Ce parc informatique devra être performant et produire une gestion fiable. L'application intègre un système complet de gestion des utilisateurs, permettant la création de comptes et l'authentification des utilisateurs. Une fois connecté, chaque utilisateur pourra accéder à cet inventaire.

La gestion des droits d'accès est structurée selon une hiérarchie claire comprenant quatre niveaux d'utilisateurs. Les visiteurs, au niveau le plus basique, peuvent uniquement accéder à la page d'accueil sans pouvoir utiliser les modules de calcul. Les utilisateurs inscrits disposent d'un accès complet aux modules et à leurs fonctionnalités. L'administrateur web possède des droits étendus lui permettant de gérer les comptes utilisateurs, notamment la consultation de la liste des inscrits, la suppression de comptes et la création de nouveaux comptes via des fichiers CSV. Au sommet de cette hiérarchie, l'administrateur système bénéficie d'un accès privilégié aux logs du système directement depuis l'interface web.

L'infrastructure technique repose sur un Raspberry Pi qui hébergera l'ensemble de la solution. Cette configuration nécessite l'installation et la configuration d'un serveur web, d'un système de gestion de base de données MySQL, ainsi que la mise en place de mesures de sécurité appropriées, notamment pour les accès SSH. L'ensemble doit former une solution cohérente et sécurisée, capable de répondre aux exigences de performance et de fiabilité attendues par le client.

*Pour le moment, nous ne disposons pas de consignes précises pour la mise en place des modules.*
**LECTURE DU CAHIER DES CHARGES SAE**

| Acteurs | Objets | Actions |
| ----- | ----- | ----- |
| administrateur système | page d'accueil | Accéder à la page d’accueil |
| administrateur web | carte SD | Se connecter |
| technicien | mot de passe | Voir la liste des utilisateurs inscrits |
| visiteur | formulaire d’inscription | Supprimer des comptes utilisateurs  |
| client | serveur web | Stocker les suppressions dans un fichier de log |
|  | le système | Gérer les mots de passe |
|  | la base de données | Consulter le fichier des logs |
|  | fichier csv | Inspecter les utilisateurs inscrits |
|  | compte utilisateur | consulter le parc informatique |
|  | parc informatique | consulter l’inventaire |
|  | l’inventaire | modifier une information du parc informatique |
|  | machine (moniteurs/unité centrale) | mettre une machine dans la parc informatique à partir d’un formulaire |
|  | liste rebut | mettre une série de machines dans l’inventaire avec un fichier csv |
|  | journal d’activité | supprimer une machine de l'inventaire et le mettre dans la liste rebut |
|  | plateforme | exporter une liste en format csv |
|  | fichier log | consulter la liste de rebut |
|  |  | changer le statut du matériel si il est remis en service |
|  |  | créer un technicien  |
|  |  | supprimer un technicien |
|  |  | créer une information pour le technicien (nom de systèmes d’exploitation, constructeur de la machine) |
|  |  | bloquer la liste de rebut |
