from flask import Blueprint, request, jsonify
from .db import get_all_usuario , actualizar_user, eliminar_usuario, get_roles, update_roles, datos_de_user, cambiar_contraseña, id_usuario_por_email
import bcrypt

usuarios_bp = Blueprint('usuarios_api', __name__, url_prefix='/usuarios')

@usuarios_bp.route('get', methods=['GET'])
def get_all_usuarios_routes():
    usuario= get_all_usuario()
    return jsonify(usuario)

@usuarios_bp.route('get/roles', methods=['GET'])
def get_roles_routes():
    roles= get_roles()
    return jsonify(roles)

@usuarios_bp.route('update/rol/<id>', methods=['PUT'])
def update_roles_route(id):  
    try:
        data = request.json
        rol_id  = data['rol_id']
        update_roles(rol_id,id)
        
        return jsonify({"message": "User updated successfully"}), 200
    except Exception as e:
        return jsonify({"error":str(e)}),500
    




@usuarios_bp.route('update/<id>/<status>', methods=['PUT'])
def update_users(id,status):  
    try:

        actualizar_user(status,id)
        
        return jsonify({"message": "User updated successfully"}), 200
    except Exception as e:
        return jsonify({"error":str(e)}),500
    



@usuarios_bp.route('/delete/<id>', methods=['DELETE'])
def delete_user(id):
    try:
        eliminar_usuario(id)
        return jsonify({"message": "Usuario eliminado exitosamente"}), 200
    except Exception as e:
        return jsonify({"error": str(e)}), 500
 
    
@usuarios_bp.route('profile/<id_user>', methods=['GET'])
def get_all_usuarios_routes_por_id(id_user):
    usuario= datos_de_user(id_user)
    return jsonify(usuario)





@usuarios_bp.route('cambiarcontraseña/<id_usuario>', methods=['PUT'])
def cambiar_contraseña_route(id_usuario):  
    data = request.json
    nueva_contraseña = data.get('nueva_contraseña')

    if not nueva_contraseña:
        return jsonify({"error": "Nueva contraseña es requerida"}), 400

    cambiar_contraseña(id_usuario, nueva_contraseña)
    return jsonify({"message": "Contraseña cambiada exitosamente"}), 200



@usuarios_bp.route('id/<email>', methods=['GET'])
def get_id_usuario_por_email(email):
    id_usuario = id_usuario_por_email(email)
    if id_usuario:
        return jsonify({"id_usuario": id_usuario}), 200
    return jsonify({"error": "Usuario no encontrado"}), 404