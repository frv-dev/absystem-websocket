import zmq
import msgpack

context = zmq.Context()

socket = context.socket(zmq.REQ)
socket.connect('tcp://localhost:5555')

socket.send(msgpack.packb({'message': 'Pagamento realizado com sucesso!'}))

message = socket.recv_string()
print(f"Resposta: {message}")
