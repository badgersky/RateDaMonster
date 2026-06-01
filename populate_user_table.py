import bcrypt
from faker import Faker
import os
import psycopg2
from dotenv import load_dotenv

load_dotenv()

fake = Faker()


def seed_users(count=100):
    try:
        conn = psycopg2.connect(
            host=os.getenv("DB_HOST", "localhost"),
            port=os.getenv("DB_PORT", 5433),
            database=os.getenv("POSTGRES_DB"),
            user=os.getenv("POSTGRES_USER"),
            password=os.getenv("POSTGRES_PASSWORD")
        )
        cur = conn.cursor()

        for _ in range(count):
            username = fake.unique.user_name()
            hashed_password = bcrypt.hashpw(
                "password123".encode("utf-8"),
                bcrypt.gensalt()
            ).decode("utf-8")

            cur.execute(
                """
                INSERT INTO users (
                    username,
                    password,
                    account_type_id,
                    is_active
                )
                VALUES (%s, %s, %s, %s)
                ON CONFLICT (username) DO NOTHING;
                """,
                (
                    username,
                    hashed_password,
                    1,
                    True
                )
            )

        conn.commit()
        cur.close()
        print(f"{count} users seeded successfully!")
    except Exception as e:
        print(f"Error: {e}")

if __name__ == '__main__':
    seed_users()