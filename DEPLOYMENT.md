# 🚀 Deployment Guide - Laravel Delivery

This guide covers deployment to various cloud platforms.

---

## 🐳 Docker Deployment (Recommended)

### Quick Start
```bash
# Clone and deploy
git clone https://github.com/Samsontesfamichael/Laravel-Delivery.git
cd Laravel-Delivery
cp .env.docker .env
docker-compose up -d
```

---

## ☁️ Cloud Platform Deployments

### 1. DigitalOcean

#### Using App Platform

1. **Create Droplet**
```bash
# Create a Ubuntu 22.04 droplet
# Minimum 2GB RAM, 2 vCPUs
```

2. **Install Docker**
```bash
ssh root@your-droplet-ip
apt update && apt install -y docker.io docker-compose
```

3. **Deploy**
```bash
git clone https://github.com/Samsontesfamichael/Laravel-Delivery.git
cd Laravel-Delivery
cp .env.docker .env
nano .env  # Update DB password
docker-compose up -d
```

4. **Setup Nginx Reverse Proxy**
```bash
apt install -y nginx
# Configure nginx with SSL
```

#### Using DigitalOcean App Platform (Container Registry)

```yaml
# app.yaml
name: laravel-delivery
region: nyc
services:
- name: web
  image:
    registry: registry.digitalocean.com/your-registry/laravel-delivery
    tag: latest
  http_port: 80
  instance_count: 2
  instance_size_slug: professional-xs
  envs:
  - key: APP_ENV
    value: production
  - key: DB_HOST
    value: ${database.DATABASE_HOST}
```

---

### 2. AWS (Amazon Web Services)

#### Option A: EC2 Instance

1. **Launch EC2 Instance**
   - AMI: Ubuntu Server 22.04
   - Instance Type: t3.small (minimum)
   - Security Group: Open ports 22, 80, 443, 3306

2. **Connect & Install**
```bash
ssh -i your-key.pem ubuntu@your-ec2-ip

# Install Docker
sudo apt update
sudo apt install -y docker.io docker-compose

# Clone & Deploy
git clone https://github.com/Samsontesfamichael/Laravel-Delivery.git
cd Laravel-Delivery
cp .env.docker .env
docker-compose up -d
```

3. **Setup RDS (MySQL)**
   - Create RDS MySQL instance
   - Update .env with RDS endpoint

4. **Setup ELB (Load Balancer)**
   - Create Application Load Balancer
   - Configure SSL certificate (ACM)

#### Option B: ECS Fargate

```json
{
  "family": "laravel-delivery",
  "networkMode": "awsvpc",
  "containerDefinitions": [
    {
      "name": "app",
      "image": "your-account.dkr.ecr.us-east-1.amazonaws.com/laravel-delivery:latest",
      "essential": true,
      "portMappings": [
        {
          "containerPort": 80,
          "protocol": "tcp"
        }
      ],
      "environment": [
        {"name": "APP_ENV", "value": "production"}
      ]
    }
  ]
}
```

---

### 3. Google Cloud Platform

#### Using Compute Engine

1. **Create VM Instance**
   - Machine Type: e2-medium
   - Boot Disk: Ubuntu 22.04

2. **Deploy**
```bash
gcloud compute ssh your-instance --zone=us-central1-a

# Install Docker
sudo apt update
sudo apt install -y docker.io docker-compose

# Clone & Deploy
git clone https://github.com/Samsontesfamichael/Laravel-Delivery.git
cd Laravel-Delivery
docker-compose up -d
```

3. **Open Firewall**
```bash
gcloud compute firewall-rules allow-http \
  --allow=tcp:80 \
  --source-ranges=0.0.0.0/0

gcloud compute firewall-rules allow-https \
  --allow=tcp:443 \
  --source-ranges=0.0.0.0/0
```

#### Using Cloud Run

```yaml
# cloudrun.yaml
apiVersion: serving.knative.dev/v1
kind: Service
metadata:
  name: laravel-delivery
spec:
  template:
    spec:
      containers:
      - image: gcr.io/PROJECT-ID/laravel-delivery
        ports:
        - containerPort: 80
        env:
        - name: APP_ENV
          value: production
```

```bash
# Deploy
gcloud run deploy laravel-delivery \
  --image gcr.io/PROJECT-ID/laravel-delivery \
  --platform managed \
  --region us-central1 \
  --allow-unauthenticated
```

---

### 4. Heroku

#### Using Heroku Container Registry

```bash
# Install Heroku CLI
brew install heroku/brew/heroku

# Login
heroku login
heroku container:login

# Create app
heroku create laravel-delivery

# Add database
heroku addons:create jawsdb:kitefin

# Set environment variables
heroku config:set APP_ENV=production
heroku config:set DB_HOST=your-db-host
heroku config:set DB_DATABASE=your-db-name

# Push and deploy
heroku container:push web
heroku container:release web
```

---

### 5. Linode

1. **Create Linode**
   - Image: Ubuntu 22.04
   - Plan: Nanode 2GB

2. **Deploy**
```bash
ssh root@your-linode-ip

# Install Docker
apt update && apt install -y docker.io docker-compose

# Clone & Deploy
git clone https://github.com/Samsontesfamichael/Laravel-Delivery.git
cd Laravel-Delivery
docker-compose up -d
```

3. **Setup Cloud Firewall**
   - Create firewall in Linode dashboard
   - Allow ports 80, 443, 22

---

### 6. Vercel

```json
{
  "builds": [
    {
      "src": "composer.json",
      "use": "@vercel/php"
    }
  ],
  "routes": [
    {
      "src": "/(.*)",
      "dest": "/public/index.php"
    }
  ]
}
```

```bash
# Install Vercel CLI
npm i -g vercel

# Deploy
vercel --prod
```

---

### 7. Railway

```bash
# Install Railway CLI
npm i -g @railway/cli

# Login
railway login

# Create project
railway init

# Add database
railway add -d mysql

# Deploy
railway up
```

---

## 🔧 Post-Deployment Setup

### SSL Certificate (Let's Encrypt)

```bash
# Using Certbot
apt install -y certbot python3-certbot-nginx
certbot --nginx -d yourdomain.com -d www.yourdomain.com
```

### Database Migration

```bash
# Run migrations
docker-compose exec app php artisan migrate

# Seed database (optional)
docker-compose exec app php artisan db:seed
```

### Queue Worker

```bash
# Start queue worker
docker-compose exec app php artisan queue:work
```

---

## 📊 Environment Variables

Required for production:

```env
APP_ENV=production
APP_DEBUG=false
APP_URL=https://yourdomain.com

# Database
DB_HOST=your-db-host
DB_PORT=3306
DB_DATABASE=laravel_delivery
DB_USERNAME=your-db-user
DB_PASSWORD=your-db-password

# Redis
REDIS_HOST=your-redis-host
REDIS_PASSWORD=your-redis-password

# Mail
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=587
MAIL_USERNAME=your-username
MAIL_PASSWORD=your-password

# N8n Webhook
N8N_WEBHOOK_URL=https://your-n8n.com
```

---

## 🔒 Security Checklist

- [ ] Update default database passwords
- [ ] Enable SSL/HTTPS
- [ ] Configure firewall rules
- [ ] Set APP_DEBUG=false
- [ ] Setup automated backups
- [ ] Configure log rotation
- [ ] Enable 2FA on cloud accounts

---

## 📞 Support

For deployment issues: teshag2006@gmail.com
