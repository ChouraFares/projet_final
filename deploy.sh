#!/bin/bash
echo "Déploiement en cours..."

# S'assurer d'être sur master
git checkout master

# Ajouter, valider et pousser les modifications
git add .
git commit -m "Mise à jour - $(date)" || echo "Rien à valider"
git push origin master

# Déployer sur la VM
ssh administrateur@192.168.80.105 "cd ~/bk_food_new && git pull origin master --force && php artisan cache:clear && php artisan config:cache"

echo "✅ Déploiement terminé avec succès !"