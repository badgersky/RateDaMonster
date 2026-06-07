import os
import random
import psycopg2
from dotenv import load_dotenv

load_dotenv()

def seed_ratings(count=2000):
    try:
        conn = psycopg2.connect(
            host=os.getenv("DB_HOST", "localhost"),
            port=os.getenv("DB_PORT", 5433),
            database=os.getenv("POSTGRES_DB"),
            user=os.getenv("POSTGRES_USER"),
            password=os.getenv("POSTGRES_PASSWORD")
        )

        cur = conn.cursor()

        used_pairs = set()

        while len(used_pairs) < count:
            user_id = random.randint(3, 104)
            monster_id = random.randint(50, 98)

            pair = (user_id, monster_id)

            if pair in used_pairs:
                continue

            used_pairs.add(pair)

            rating = random.randint(1, 10)

            sourness = max(1, min(10, rating + random.randint(-2, 2)))
            sweetness = max(1, min(10, rating + random.randint(-2, 2)))
            carbonation = max(1, min(10, rating + random.randint(-2, 2)))
            energy_kick = max(1, min(10, rating + random.randint(-2, 2)))

            cur.execute(
                """
                INSERT INTO ratings (
                    user_id,
                    monster_id,
                    rating,
                    sourness,
                    sweetness,
                    carbonation,
                    energy_kick
                )
                VALUES (%s, %s, %s, %s, %s, %s, %s)
                ON CONFLICT (user_id, monster_id) DO NOTHING;
                """,
                (
                    user_id,
                    monster_id,
                    rating,
                    sourness,
                    sweetness,
                    carbonation,
                    energy_kick
                )
            )

        conn.commit()
        cur.close()
        conn.close()

        print(f"{count} ratings seeded successfully!")

    except Exception as e:
        print(f"Error: {e}")


if __name__ == '__main__':
    seed_ratings()