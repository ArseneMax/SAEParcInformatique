   
# **Cahier des charges**

**I./ Introduction**

### **1.Contexte**

Le projet consiste à développer une application web de gestion de parc informatique hébergée sur un serveur Raspberry Pi 4\. Cette application permettra de gérer un inventaire complet de machines (moniteurs et unités centrales) avec un système d'authentification multi-niveaux et un suivi détaillé de toutes les opérations. L'infrastructure technique repose sur une stack LAMP (Linux, Apache/Nginx, MySQL, PHP) complétée par Python pour les traitements avancés. L'équipe devra gérer l'intégralité du cycle de développement, de l'installation système jusqu'au déploiement en production, incluant la configuration du serveur, la sécurisation des accès SSH et la mise en place de l'environnement applicatif.

### **2.Objectifs**

Ce cahier des charges définit les spécifications techniques et fonctionnelles de la plateforme. Il établit l'architecture logicielle à mettre en œuvre, les flux de données entre les composants, et les normes de sécurité à respecter. Le document servira de référence pour le développement backend en PHP et Python, l'implémentation de la base de données MySQL, et la création de l'interface front end responsive. L'objectif est de livrer une application web performante, sécurisée et maintenable, respectant les standards de l'industrie en termes de qualité de code et d'architecture logicielle.

### **3.Structure**

Ce document se compose de quatre sections principales. L'introduction présente le contexte du projet et les objectifs de développement. L'énoncé détaille les fonctionnalités de la plateforme en décrivant les acteurs, les objets du système et les actions possibles pour chaque niveau d'accès. La section pré-requis liste les technologies et ressources nécessaires au développement et au déploiement de l'application. Enfin, les priorités définissent l'ordre de développement des différents modules pour assurer une livraison progressive et cohérente du projet.

### **4.Documents**

Documents référencés : 0 pour l'instant

**II./ Enoncé** 

### **1\. Présentation générale**

La plateforme est une application web de gestion de parc informatique permettant de gérer un inventaire de machines et les utilisateurs qui y accèdent. L'authentification repose sur des sessions sécurisées avec hachage des mots de passe. Un système de logs trace toutes les actions importantes effectuées sur la plateforme.

### **2\. Acteurs et niveaux d'accès**

Le système distingue cinq types d'acteurs avec des droits progressifs. Le visiteur peut uniquement consulter la page d'accueil. Le client, une fois authentifié, accède en lecture à l'inventaire du parc informatique. Le technicien dispose des mêmes droits que le client et peut en plus modifier l'inventaire, ajouter ou supprimer des machines, importer des données via CSV et gérer la liste de rebut. L'administrateur web possède tous les droits du technicien auxquels s'ajoutent la gestion complète des comptes utilisateurs, la création d'informations système et la consultation des logs. L'administrateur système bénéficie de l'accès le plus élevé avec des capacités de monitoring avancé du serveur.

### **3\. Objets du système**

La plateforme manipule plusieurs entités principales. Les comptes utilisateurs stockent les identifiants, mots de passe hachés et rôles. Le parc informatique contient l'inventaire des machines avec leurs caractéristiques (type, constructeur, système d'exploitation, statut). La liste de rebut conserve les machines retirées du service. Les fichiers CSV permettent l'import et l'export de données en masse. Le système de logs enregistre toutes les actions critiques avec horodatage et identification de l'acteur. Les informations système référencent les constructeurs et systèmes d'exploitation disponibles.

### **4\. Fonctionnalités principales**

Le visiteur accède uniquement à la page d'accueil de la plateforme. Le client peut se connecter avec ses identifiants et consulter l'inventaire complet du parc informatique. Le technicien peut ajouter une machine via un formulaire, importer plusieurs machines simultanément avec un fichier CSV, modifier les informations d'une machine existante, transférer une machine vers la liste de rebut ou la remettre en service, et exporter des données au format CSV. L'administrateur web visualise la liste des utilisateurs inscrits, crée ou supprime des comptes techniciens, supprime des comptes clients, ajoute des constructeurs ou systèmes d'exploitation dans le système, et consulte les logs d'activité. L'administrateur système accède aux logs système détaillés via l'interface web et dispose d'outils de monitoring du serveur.

**III./ Pré-requis**

La réalisation de l'application nécessite plusieurs technologies et ressources tant logicielles que matérielles. Le développement s'appuiera sur un ensemble complet de langages de programmation et d'outils pour couvrir tous les aspects du projet.

Le développement backend sera assuré par PHP et Python, deux langages complémentaires qui répondront aux différents besoins de l'application. PHP servira de base pour créer les fonctionnalités web dynamiques, gérer les sessions utilisateurs, implémenter l'authentification avec hachage sécurisé des mots de passe, et assurer le routage des requêtes HTTP vers les contrôleurs appropriés. 

Python sera utilisé pour développer les scripts de traitement des fichiers CSV lors des imports en masse, permettant de parser et valider les données avant leur insertion dans la base. La gestion des données sera assurée par SQL pour interagir avec la base de données MySQL, en utilisant systématiquement des requêtes préparées pour prévenir les injections SQL et garantir la sécurité.

Pour la partie frontend, HTML5 fournira la structure des pages web, tandis que CSS assurera la mise en forme avec un design responsive qui s'adaptera automatiquement aux différentes tailles d'écran. JavaScript gérera les interactions dynamiques côté client pour améliorer l'expérience utilisateur avec des validations en temps réel et des mises à jour partielles de la page. Le langage R sera intégré pour générer des visualisations statistiques et des rapports graphiques sur l'état du parc informatique.  
L'infrastructure technique reposera sur un Raspberry Pi 4 qui servira de serveur de production. Le système d'exploitation Raspberry Pi OS sera installé sur une carte SD de capacité suffisante pour stocker le système et les données de l'application.  
   
Un serveur web Apache ou Nginx sera configuré pour servir l'application PHP avec les modules nécessaires activés. MySQL gérera la base de données relationnelle avec des tables normalisées et des index optimisés pour les performances. L'accès au serveur sera sécurisé par SSH avec authentification par clé publique, désactivant l'authentification par mot de passe pour renforcer la sécurité.

**IV./ Priorités**

Les priorités éventuelles du développement à confirmer avec le client :

1. **Configuration du Serveur et Installation du Système**

    Notre première priorité est la mise en place d'une infrastructure technique solide. Cela comprend la configuration complète du serveur Raspberry Pi, l'installation du système d'exploitation, la mise en place du serveur web et le déploiement de la base de données MySQL. Cette étape fondamentale doit garantir un environnement stable et performant pour notre application.

2. **Développement des modules de gestion du parc informatique**

    Au cœur de notre plateforme se trouve un parc informatique. Une fois les spécifications reçues du client, nous concentrerons nos efforts sur le développement de ce parc informatique. Celui-ci devra être conçu avec une attention particulière portée à une gestion optimale de l’inventaire de celui-ci.

3. **Gestion des Utilisateurs et des Droits d'Accès**

    La mise en place d'un système robuste de gestion des utilisateurs constitue notre troisième priorité. Ce système devra gérer efficacement les différents niveaux d'accès, du simple visiteur à l'administrateur système, en passant par l'utilisateur inscrit et l'administrateur web. La sécurité et le contrôle des accès sont essentiels pour préserver l'intégrité de la plateforme.

4. **Conception de l'Interface Utilisateur**

    L'interface utilisateur doit être intuitive et accessible pour tous les types d'utilisateurs. Nous développerons une interface responsive qui guidera naturellement les utilisateurs dans leur utilisation des différents modules. Une attention particulière sera portée à l'expérience utilisateur pour faciliter l'adoption de la plateforme.

5. **Documentation et Support Utilisateur**

    La création d'une documentation complète et claire est essentielle. Elle comprendra des guides d'utilisation, un texte explicatif détaillé et une vidéo de présentation. Ces ressources faciliteront non seulement l'utilisation de la plateforme mais serviront également de support pour l'évaluation du projet.

6. **Sécurité de l'Application**

    La sécurisation globale de l'application est une priorité. Cela inclut la protection des accès SSH, la sécurisation des communications entre le frontend et le backend, et la mise en place de mesures de protection des données. Ces éléments sont cruciaux pour garantir la confidentialité et l'intégrité du système.

7. **Tests et Validation**

    Enfin, une phase complète de tests et de validation sera menée avant la mise en production. Cette étape permettra de vérifier le bon fonctionnement de chaque module, la performance globale de l'application et la robustesse des mesures de sécurité mises en place. Cette validation finale est indispensable pour s'assurer que notre solution répond pleinement aux attentes du client.
