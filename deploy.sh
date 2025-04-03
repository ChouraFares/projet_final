#!/bin/bash
echo "Déploiement en cours..."

# Configuration Git
git config --global core.autocrlf input

# Vérifier la structure du dépôt
if [ -d "projet_final/.git" ]; then
    echo "❌ Erreur : Dépôt Git imbriqué détecté dans 'projet_final'"
    echo "Solution : Exécutez les commandes suivantes puis relancez le script :"
    echo "  git rm --cached projet_final -r"
    echo "  mv projet_final/* ."
    echo "  rm -rf projet_final"
    exit 1
fi

# Vérifier la branche
if ! git rev-parse --verify master >/dev/null 2>&1; then
    echo "ℹ️ Création de la branche master..."
    git checkout -b master || { echo "❌ Erreur : Impossible de créer master"; exit 1; }
fi

# S'assurer d'être sur la branche master localement
git checkout master || { echo "❌ Erreur : Impossible de passer sur master"; exit 1; }

# Vérifier s'il y a des conflits non résolus dans Git
if git status | grep -q "unmerged paths"; then
    echo "❌ Des conflits Git non résolus ont été détectés !"
    echo "Résolvez les conflits avant de continuer :"
    git status
    exit 1
fi

# Vérifier la présence de marqueurs de conflit localement, en excluant vendor/, storage/framework/ et deploy.sh
echo "Vérification des marqueurs de conflit (<<<<<<<)..."
CONFLICT_FILES=$(grep -r "<<<<<<< HEAD" . --exclude-dir=vendor --exclude-dir=storage/framework --exclude=deploy.sh 2>/dev/null)
if [ -n "$CONFLICT_FILES" ]; then
    echo "❌ Des marqueurs de conflit ont été détectés dans les fichiers suivants :"
    echo "$CONFLICT_FILES"
    echo "Veuillez les corriger manuellement avant de déployer."
    exit 1
else
    echo "✅ Aucun marqueur de conflit trouvé localement."
fi

# Ajouter, valider et pousser les modifications locales
git add .
git commit -m "Mise à jour - $(date)" || echo "ℹ️ Rien à valider"
git push origin master || { echo "❌ Erreur lors du push vers GitHub"; exit 1; }

# Synchroniser la VM avec GitHub et nettoyer le cache
echo "Synchronisation de la VM avec GitHub..."
ssh administrateur@192.168.80.105 "cd ~/bk_food_new && git fetch && git reset --hard origin/master && rm -rf storage/framework/views/* && php artisan cache:clear && php artisan view:clear && php artisan config:cache" || { echo "❌ Erreur lors du déploiement sur la VM"; exit 1; }

# Vérification finale sur la VM, en excluant vendor/, storage/framework/ et deploy.sh
echo "Vérification finale sur la VM..."
CONFLICT_CHECK=$(ssh administrateur@192.168.80.105 "cd ~/bk_food_new && grep -r '<<<<<<< HEAD' . --exclude-dir=vendor --exclude-dir=storage/framework --exclude=deploy.sh 2>/dev/null")
if [ -n "$CONFLICT_CHECK" ]; then
    echo "❌ Erreur : Des marqueurs de conflit ont été détectés sur la VM après déploiement :"
    echo "$CONFLICT_CHECK"
    exit 1
else
    echo "✅ Aucun marqueur de conflit trouvé sur la VM."
fi

echo "✅ Déploiement terminé avec succès !"