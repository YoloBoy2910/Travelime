from g4f.client import Client
import sys

if len(sys.argv) > 1:
    user_question = sys.argv[1]
else:
    user_question = "how are you?"

client = Client()
response = client.chat.completions.create(
    model="gpt-3.5-turbo",
    messages=[{"role": "user", "content": user_question}],
)
print(response.choices[0].message.content)

