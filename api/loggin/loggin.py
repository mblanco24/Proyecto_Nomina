from flask import Blueprint, jsonify, request,current_app,make_response
from .db import user_auth
import bcrypt
import jwt
import datetime

loggin = Blueprint('loggin', __name__, url_prefix='/loggin')

@loggin.route('api', methods = ['POST'])
def loggin_route():
    try:
            data = request.json
            usuario = data['username'].upper()
            password = data['password']

            if usuario:
                valor = user_auth(usuario)
                if not valor:
                    return jsonify({"Respuesta": "Usuario no encontrado"}), 404

                passHash = valor[0][1]
                if passHash and bcrypt.checkpw(password.encode('utf-8'), passHash.encode('utf-8')):

                    access_token = jwt.encode({
                        'user': usuario,
                        'exp': datetime.datetime.utcnow() + datetime.timedelta(minutes=15)
                    }, current_app.config['SECRET_KEY'], algorithm='HS256')

                    refresh_token = jwt.encode({
                        'user': usuario,
                        'exp': datetime.datetime.utcnow() + datetime.timedelta(days=7)
                    }, current_app.config['SECRET_KEY'], algorithm='HS256')
 
                    resp = make_response(jsonify({"mensaje": "Login exitoso"}))
                    resp.set_cookie('access_token', access_token, httponly=True, samesite='Lax')
                    resp.set_cookie('refresh_token', refresh_token, httponly=True, samesite='Lax')
                    return resp


            return jsonify({"error": "Credenciales inválidas"}), 401
    except Exception as e:
        return jsonify({"Respuesta": str(e)}), 500



@loggin.route('/refresh', methods=['POST'])
def refresh_token():
    token = request.cookies.get('refresh_token')
    if not token:
        return jsonify({'message': 'Refresh token requerido'}), 401

    try:
        data = jwt.decode(token, current_app.config['SECRET_KEY'], algorithms=["HS256"])
        usuario = data['user']

        new_access_token = jwt.encode({
            'user': usuario,
            'exp': datetime.datetime.utcnow() + datetime.timedelta(minutes=15)
        }, current_app.config['SECRET_KEY'], algorithm='HS256')

        resp = make_response(jsonify({"mensaje": "Token renovado"}))
        resp.set_cookie('access_token', new_access_token, httponly=True, samesite='Lax')
        return resp

    except jwt.ExpiredSignatureError:
        return jsonify({'message': 'Refresh token expirado'}), 401
    except jwt.InvalidTokenError:
        return jsonify({'message': 'Refresh token inválido'}), 401


@loggin.route('/logout', methods=['POST'])
def logout():
    resp = make_response(jsonify({"mensaje": "Sesión cerrada"}))
    resp.set_cookie('access_token', '', expires=0)
    resp.set_cookie('refresh_token', '', expires=0)
    return resp
